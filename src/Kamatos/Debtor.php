<?php
namespace Kamatos;

/**
 * Description of Debtor
 * 
 * @author Gergely Hegedűs <work@hegedusgergely.com>
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
class Debtor
{
    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var string
     */
    private $lastName;

    /**
     * @var float
     */
    private $debt;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $interest;
    
    /**
     * Instantiates a new Debtor object.
     * 
     * @param string $firstName The debtor's first name.
     * @param string $lastName The debtor's last name.
     * @param float $debt The debt.
     * @param int $duration The duration.
     * @param int $interest The interest.
     */
    public function __construct($firstName, $lastName, $debt, $duration, $interest)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->debt = $debt;
        $this->duration = $duration;
        $this->interest = $interest;
    }
    
    /**
     * Returns the debtor's first name.
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Returns the debtor's last name.
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Returns the debt.
     * 
     * @return float
     */
    public function getDebt()
    {
        return $this->debt;
    }

    /**
     * Returns the duration.
     * 
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Returns the interest.
     * 
     * @return int
     */
    public function getInterest()
    {
        return $this->interest;
    }
}
