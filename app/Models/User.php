<?php


namespace App\Models;


use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="users")
 */
class User extends Model
{
    /**
     * @OGeneratedValue(strategy="AUTO")
     * @id @Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @name @Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @email @Column(type="string", nullable=false)
     */
    protected $email;

    /**
     * @password @Column(type="string", nullable=false)
     */
    protected $password;

    /**
     * @remember_token @Column(type="string", nullable=true)
     */
    protected $remember_token;

    /**
     * @remember_identifier @Column(type="string", nullable=true)
     */
    protected $remember_identifier;
}