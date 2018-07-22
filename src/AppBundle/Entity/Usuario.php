<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface, \Serializable
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
     * @ORM\Column(name="contrasena", type="string", length=255, unique=false)
     */
    private $contrasena;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_usuario", type="string", length=25, unique=false)
     */
    private $tipo_usuario;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }
    /**
     * @var $tickets
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="usuario")
     */
    private $tickets;
    
    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="usuarioId")
     */
    private $notas;

    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param mixed $tickets
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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



    /**
     * @see \Serializable::serialize()
     */
    public function serialize(){
        return serialize(array(
            $this->id,
            $this->username,
            $this->contrasena,
        ));
    }
    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized){
        list (
            $this->id,
            $this->username,
            $this->contrasena,
            )=unserialize($serialized,array('allowed_classes'=>false));
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [
            $this->getTipoUsuario()
        ];
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
        return $this->getContrasena();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Usuario
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Add nota
     *
     * @param \AppBundle\Entity\Nota $nota
     *
     * @return Usuario
     */
    public function addNota(\AppBundle\Entity\Nota $nota)
    {
        $this->notas[] = $nota;

        return $this;
    }

    /**
     * Remove nota
     *
     * @param \AppBundle\Entity\Nota $nota
     */
    public function removeNota(\AppBundle\Entity\Nota $nota)
    {
        $this->notas->removeElement($nota);
    }

    /**
     * Get notas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotas()
    {
        return $this->notas;
    }
}
