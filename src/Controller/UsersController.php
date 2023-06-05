<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

use function PHPSTORM_META\map;
use DateTime;
/**
 * Users Controllerq
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }
    

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }
 /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    //add 
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function login()
    {
        $this->layout = 'login.php';
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Users', 'action' => 'index']);
            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Usuario o contraseña incorrectos');
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        $errors = [];
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $password = $this->request->getData('password');
            $passwordRepeat = $this->request->getData('passwordRepeat');

            $validations = [
                'length' => [
                    'rule' => ['minLength', 8],
                    'message' => 'La contraseña debe tener al menos 8 caracteres.'
                ],
                'uppercase' => [
                    'rule' => ['custom', '/[A-Z]/'],
                    'message' => 'La contraseña debe contener al menos una letra mayúscula.'
                ],
                'number' => [
                    'rule' => ['custom', '/\d/'],
                    'message' => 'La contraseña debe contener al menos un número.'
                ],
                'specialChar' => [
                    'rule' => ['custom', '/[!@#$%^&*(),.?":{}|<>]/'],
                    'message' => 'La contraseña debe contener al menos un carácter especial.'
                ],
                'match' => [
                    'rule' => function ($value, $context) use ($passwordRepeat) {
                        return $value === $passwordRepeat;
                    },
                    'message' => 'Las contraseñas no coinciden.'
                ]
            ];

            $validator = new \Cake\Validation\Validator();
            $validator->add('password', $validations);

            $errors = $validator->validate($this->request->getData());

            if (empty($errors) && $this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido registrado.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('El usuario no pudo ser registrado. Por favor, intente nuevamente.'));
            }
        }
        $this->set(compact('user'));
        $this->set('errors', $errors);
        $this->set('_serialize', ['user']);
    }

    public function recoverPass()
    {
        if ($this->request->is('post')) {
            $correo = $this->request->getData('email');
            $usuario = $this->Users->findByEmail($correo)->first();

            if ($usuario) {
                echo "Se ha enviado al correo electroninco el link de recuperación de contraseña para el correo proporcionado";
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);

                $url = Router::url([
                    'controller' => 'Users',
                    'action' => 'resetPassword',
                    '?' => [
                        'selector' => $selector,
                        'validator' => bin2hex($token)
                    ]
                ], true);

                $expires = date("U") + 1800;

                $pwdresetTable = TableRegistry::getTableLocator()->get('Pwdreset');

                
                $pwdresetTable->deleteAll(['pwdResetEmail' => $correo]);
                $pwdresetTable = $this->getTableLocator()->get('Pwdreset');

                $hashed_token = password_hash($token, PASSWORD_DEFAULT);
                $data = [
                    'pwdResetEmail' => $correo,
                    'pwdResetSelector' => $selector,
                    'pwdResetToken' => $hashed_token,
                    'pwdResetExpires' => $expires,
                ];

                $pwdresetEntity = $pwdresetTable->newEntity($data);
                $pwdresetTable->save($pwdresetEntity);

                $to = $correo;
                $subject = 'Restablecimiento de contraseña';

                $message = '<p>Haz clic en el enlace para restablecer tu contraseña:</p>';
                $message .= "<p>Aquí está tu enlace de restablecimiento de contraseña:</br>";
                $message .= '<a href="' . $url . '">' . $url . '</a></p>';

                $email = new Email('default');
                $email->setTo($to)
                    ->setSubject($subject)
                    ->setEmailFormat('html')
                    ->send($message);
            }else{
                echo "El correo electronico ".$correo." no se encuentra registrado en el sistema";
            }
        }
    }


    public function resetPassword()
    {
        $selector = $this->request->getQuery('selector');
        $validator = $this->request->getQuery('validator');

        if (empty($selector) || empty($validator)) {
            echo "¡No se pudo validar tu solicitud!";
        } else {
            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                $this->render('reset_password');

                if ($this->request->is('post')) {
                    $pwd = $this->request->getData('pwd');

                    $currentDate = date("U");
                    $pwdresetTable = TableRegistry::getTableLocator()->get('Pwdreset');
                    $resetRecord = $pwdresetTable->find()
                        ->where([
                            'pwdResetSelector' => $selector,
                            'pwdResetExpires >' => $currentDate
                        ])
                        ->first();

                    if ($resetRecord) {
                        $tokenBin = hex2bin($validator);
                        $tokenCheck = password_verify($tokenBin, $resetRecord->pwdResetToken);

                        if ($tokenCheck === false) {
                            echo "El link ha expirado!";
                        } elseif ($tokenCheck === true) {
                            $tokenEmail = $resetRecord->pwdResetEmail;

                            $usersTable = TableRegistry::getTableLocator()->get('Users');
                            $userRecord = $usersTable->find()
                                ->where(['email' => $tokenEmail])
                                ->first();

                            if ($userRecord) {
                                $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);
                                $UserRc = $this->Users->updateAll(
                                    [
                                        'password' => $newPwdHash,
                                        'modified' => date('Y-m-d H:i:s')
                                    ],
                                    ['email' => $tokenEmail]
                                );

                                if ($UserRc) {
                                    $pwdResetTable = TableRegistry::getTableLocator()->get('Pwdreset');
                                    $resetRc = $pwdResetTable->deleteAll(['pwdResetEmail' => $tokenEmail]);
                                    if ($resetRc) {
                                        $usersTable = TableRegistry::getTableLocator()->get('Users');
                                        $updatedUserRecord = $usersTable->find()
                                            ->where(['email' => $tokenEmail])
                                            ->first();

                                        if ($updatedUserRecord && password_verify($pwd, $updatedUserRecord->password)) {
                                            echo "¡La contraseña se ha cambiado correctamente!";
                                        } else {
                                            echo "No se pudo verificar la actualización de la contraseña.";
                                        }
                                    } else {
                                        echo "Cambio de contraseña inválido";
                                    }
                                }
                            } else {
                                echo "¡Cambio de contraseña inválido!";
                            }
                        } else {
                            echo "¡Usuario no encontrado!";
                        }
                    } else {
                        echo "¡Solicitud de reinicio inválida!";
                    }
                }
            }
        }
    }



    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('Sesion cerrada correctamente');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $action = $this->request->getParam('action');

        switch ($action) {
            case 'login':
                $this->viewBuilder()->setLayout('login');
                break;
            case 'register':
                $this->viewBuilder()->setLayout('registerL');
                break;
            case 'recoverPass':
                $this->viewBuilder()->setLayout('recover');
                break;
            case 'resetPassword':
                $this->viewBuilder()->setLayout('reset');
                break;
        }

        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'register', 'recoverPass', 'resetPassword']);

        if (($this->Authentication->getResult())->isValid()) {
            $this->set('loggedIn', true);
        } else {
            $this->set('loggedIn', false);
        }
    }
}
