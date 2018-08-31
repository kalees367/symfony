<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @MongoDB\Document
 */
class User
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */

    protected $firstName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $lastName;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $email;

    /**
     * @MongoDB\Field(type="hash")
     */

    protected $mobile;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $dateofBirth;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $education;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $bloodGroup;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $gender;
    
    /**
     * @MongoDB\Field(type="date")
     */
    protected $created_date;

    public function getId() {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function setEmail($email)
    {
       // $this->email = $email;
         $this->email =   explode(',', $email);
    }

    public function getEmail()
    {
         return $this->email;
       // return $this->email = implode(",",$this->email) ;
    }

    public function setMobile($mobile)
    {
       // $this->mobile = $mobile;
        $this->mobile =   explode(',', $mobile);
        
    
    }

    public function getMobile()
    {
        return $this->mobile;
        // return $this->mobile = implode(",",$this->mobile) ;
    }

    public function setDateofBirth($dateofBirth)
    {
        $this->dateofBirth = $dateofBirth;
    }

    public function getDateofBirth()
    {
        return $this->dateofBirth;
    }

    public function setEducation($education)
    {
       // $this->education = $education;
         $this->education =   explode(',', $education);
    }

    public function getEducation()
    {
        return $this->education;
       // return $this->education = implode(",",$this->education) ;
    }

    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;
    }

    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }
}
