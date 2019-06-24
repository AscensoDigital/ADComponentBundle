<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 24-09-18
 * Time: 0:33
 */

namespace AscensoDigital\ComponentBundle\Security\Encoder;


use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class Sha1LegacyPasswordEncoder extends BasePasswordEncoder
{
    private $algorithm;

    public function __construct($algorithm = "sha1")
    {
        $this->algorithm = $algorithm;
    }

    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }
        return sha1($salt.$raw);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return !$this->isPasswordTooLong($raw) && $this->comparePasswords($encoded, $this->encodePassword($raw, $salt));
    }
}