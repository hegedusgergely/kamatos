<?php

/**
 * This Class calculates the interests.
 *
 * Should do another one to echo the result.
 */

class Credit
{

    protected $loan;

    protected $duration;

    protected $interest;

    protected $interestForAMonth;

    protected $reedemForAMonth;

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

        $this -> setReedemForAMonth(1);

        $this -> setLoanCounter(1);

        $this -> setInterestCounter(1);

        $this -> setSumInterestRate(1);

        $this -> __toString();
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

    public function setReedemForAMonth($reedemForAMonth)
    {
        $this -> reedemForAMonth = $this -> getLoan() / $this -> getDuration();
    }

    public function getReedemForAMonth()
    {
        return $this -> reedemForAMonth;
    }

    public function setLoanCounter($loanCounter)
    {
        $this -> loanCounter[0] = $this -> getLoan();

        $this -> loanCounter[1] = $this -> getLoan() - $this -> getReedemForAMonth();

        for ($i = 1; $i < $this -> getDuration()-1; $i ++)
        {
            $this -> loanCounter[$i+1] = $this -> loanCounter[$i] - $this -> getReedemForAMonth();
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

    public function __toString()
    {
        // Egy összesítő arról, hogy milyen adatokkal is számolunk.
        echo "
        <div class='row'>
            <p class='ten columns offset-by-one'>
                A felvett hitel összege
                <strong>".number_format($this -> getLoan(),0,',',' ')."</strong> Ft, <strong>".$this -> getDuration()."</strong> hónapra <strong>"
                .$this -> getInterest()."</strong>%-os kamattal.
                <br>
            </p>
        </div>";

        // Értékek a véglegesen visszafizetendő összegekről.
        $all = ($this -> getLoan() + $this -> getSumInterest()[$this -> getDuration()-1]);
        $monthly = $all / $this -> getDuration();
        echo "
        <div class='row'>
            <p class='eight columns offset-by-two'>
                Összesen visszavizetendő: <strong>".number_format($all,0,',',' ')
                .'</strong> Ft ami havonta: <strong>'.number_format($monthly,0,',',' ').'</strong> Ft.
            </p>
        </div>';

        //Táblázat
        echo '
            <div class="row">
            <table class="ten columns offset-by-one">
                <tr>
                    <th>Hónap</th>
                    <th>Tőkemaradvány</th>
                    <th>Kamat adott hónapban</th>
                    <th>Kamat adott hónapig</th>
                </tr>';

        for ($i = 0; $i < count($this -> getLoanCounter()) ; $i ++)
        {
            echo "<tr>"."<td>".($i+1)."</td>"
            ."<td>".number_format($this -> getLoanCounter()[$i],0,',',' ')."</td>"
            ."<td>".number_format($this -> getInterestCounter()[$i],0,',',' ')."</td>"
            ."<td>".number_format($this -> getSumInterest()[$i],0,',',' ')."</td></tr>";
        }

        echo "</table>
        </div>";
    }
}
?>
