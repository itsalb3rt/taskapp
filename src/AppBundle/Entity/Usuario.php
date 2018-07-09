<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasena", type="string", length=25, unique=false)
     */
    private $contrasena;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_usuario", type="string", length=25, unique=false)
     */
    private $tipo_usuario;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * @param string $contrasena
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    /**
     * @return string
     */
    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }

    /**
     * @param string $tipo_usuario
     */
    public function setTipoUsuario($tipo_usuario)
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        // En este caso definimos un rol fijo, en el caso de que tengamos un campo role en la tabla de la BBDD    tendríamos que hacer $this->getRole()
        return array($this->getTipoUsuario());
    }

    public function eraseCredentials()
    {
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        $this->getContrasena();
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nombre;
    }
}

