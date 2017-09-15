<?php


namespace BlogBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class Users implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string username
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @var string password
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     * @var string firstname
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     * @var string lastname
     */
    protected $lastname;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @ORM\Column(type="string")
     * @var string email
     */
    protected $email;

    /**
     * @ORM\Column(type="date")
     */
    protected $age;

    /**
     * @ORM\Column(type="string")
     * @var string sex
     */
    protected $sex;


    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     *
     * @var ArrayCollection $userRoles
     */
    protected $userRoles;


    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string salt
     */
    protected $salt;



    /**
     * Геттер для соли к паролю.
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Сеттер для соли к паролю.
     *
     * @param string $value The salt.
     */
    public function setSalt($value)
    {
        $this->salt = $value;
    }




    /**
     * Геттер для имени пользователя.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Сеттер для имени пользователя.
     *
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }

    /**
     * Геттер для пароля.
     *
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Сеттер для пароля.
     *
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }


    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }



    /**
     * Геттер для ролей пользователя.
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Конструктор класса User
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Сброс прав пользователя.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Геттер для массива ролей.
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    /**
     * Сравнивает пользователя с другим пользователем и определяет
     * один и тот же ли это человек.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }


}