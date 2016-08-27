<?php

/**
 * This Class calculates the interests.
 *
 * Should do another one to echo the result.
 */

namespace Kamatos;

class Count
{

    protected $loan;

    protected $duration;

    protected $interest;

    protected $interestForAMonth;

    protected $repaymentForAMonth;

    protected $loanCounter;

    protected $interestCounter;

    protected $sumInterestRate;

    /**
     * Constructor
     */
    public function __construct($loan, $duration, $interest)
    {
        $this -> loan = $loan;

        $this -> duration = $duration;

        $this -> interest = $interest;

        $this -> setInterestForAMonth(1);

        $this -> setRepaymentForAMonth(1);

        $this -> setLoanCounter(1);

        $this -> setInterestCounter(1);

        $this -> setSumInterestRate(1);
    }

    /**
     * Getters and Setters
     */
    public function setLoan($loan)
    {
        $this -> loan = $loan;
    }

    public function getLoan()
    {
        return $this -> loan;
    }

    public function setDuration($duration)
    {
        $this -> duration = $duration;
    }

    public function getDuration()
    {
        return $this -> duration;
    }

    public function setInterest($interest)
    {
        $this -> interest = $interest;
    }

    public function getInterest()
    {
        return $this -> interest;
    }

    public function setInterestForAMonth($interestForAMonth)
    {
        $this -> interestForAMonth = $this -> getInterest() / 12;
    }

    public function getInterestForAMonth()
    {
        return $this -> interestForAMonth;
    }

    public function setRepaymentForAMonth($repaymentForAMonth)
    {
        $this -> repaymentForAMonth = $this -> getLoan() / $this -> getDuration();
    }

    public function getRepaymentForAMonth()
    {
        return $this -> repaymentForAMonth;
    }

    public function setLoanCounter($loanCounter)
    {
        $this -> loanCounter[0] = $this -> getLoan();

        $this -> loanCounter[1] = $this -> getLoan() - $this -> getRepaymentForAMonth();

        for ($i = 1; $i < $this -> getDuration()-1; $i ++)
        {
            $this -> loanCounter[$i+1] = $this -> loanCounter[$i] - $this -> getRepaymentForAMonth();
        }
    }

    public function getLoanCounter()
    {
        return $this -> loanCounter;
    }

    public function setInterestCounter($interestCounter)
    {
        foreach ($this -> getLoanCounter() as $i => $value)
        {
            $this -> interestCounter[$i] = ($value * $this -> getInterestForAMonth()) / 100;
        }
    }

    public function getInterestCounter()
    {
        return $this -> interestCounter;
    }

    public function setSuminterestrate($sumInterest)
    {
        $this -> sumInterest[0] = $this -> getInterestCounter()[0];

        for ($i = 1; $i < count($this -> getLoanCounter()) ; $i ++)
        {
            $this -> sumInterest[$i] = $this -> sumInterest[$i-1] + $this -> getInterestCounter()[$i];
        }
    }

    public function getSumInterest()
    {
        return $this -> sumInterest;
    }
}
?>
