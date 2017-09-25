<?php
/**
*  Ez az osztály hivatott a számítások elvégzésére.
*/
class Credit
{
    // Tőke
    protected $loan;
    // Futamidő
    protected $durationInMonth;
    // Kamat egy évre
    protected $interestRate;
    // Kamat egy hónapra
    protected $interestRateForAMonth;
    // Egy hónapra eső tőke törlesztő
    protected $reedemForAMonth;
    // Ez számolja a tőke maradványokat minden hónapra.
    protected $loanCounter;

    protected $interestRateCounter;

    protected $sumInterestRate;


    // SETTERS AND GETTERS
    public function setLoan($loan)
    {
        $this->loan = $loan;
    }

    public function getLoan()
    {
        return $this->loan;
    }

    public function setDurationInMonth($durationInMonth)
    {
        $this->durationInMonth = $durationInMonth;
    }

    public function getDurationInMonth()
    {
        return $this->durationInMonth;
    }

    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
    }

    public function getInterestRate()
    {
        return $this->interestRate;
    }

    public function setInterestRateForAMonth($interestRateForAMonth)
    {
        $this->interestRateForAMonth = $this->getInterestRate() / 12;
    }

    public function getInterestRateForAMonth()
    {
        return $this->interestRateForAMonth;
    }

    public function setReedemForAMonth($reedemForAMonth)
    {
        $this->reedemForAMonth = $this->getLoan() / $this->getDurationInMonth();
    }

    public function getReedemForAMonth()
    {
        return $this->reedemForAMonth;
    }

    public function setLoanCounter($loanCounter)
    {
        $this->loanCounter[0] = $this->getLoan();

        $this->loanCounter[1] = $this->getLoan() - $this->getReedemForAMonth();

        for ($i = 1; $i < $this->getDurationInMonth()-1; $i ++)
        {
            $this->loanCounter[$i+1] = $this->loanCounter[$i] - $this->getReedemForAMonth();
        }
    }

    public function getLoanCounter()
    {
        return $this->loanCounter;
    }

    public function setInterestRateCounter($interestRateCounter)
    {
        foreach ($this->getLoanCounter() as $i => $value)
        {
            $this->interestRateCounter[$i] = ($value * $this->getInterestRateForAMonth()) / 100;
        }
    }

    public function getInterestRateCounter()
    {
        return $this->interestRateCounter;
    }

    public function setSuminterestrate($sumInterestRate)
    {
        $this->sumInterestRate[0] = $this->getInterestRateCounter()[0];

        for ($i = 1; $i < count($this->getLoanCounter()) ; $i ++)
        {
            $this->sumInterestRate[$i] = $this->sumInterestRate[$i-1] + $this->getInterestRateCounter()[$i];
        }
    }

    public function getSumInterestRate()
    {
        return $this->sumInterestRate;
    }

    public function __toString()
    {
        $all = ($this->getLoan() + $this->getSumInterestRate()[$this->getDurationInMonth()-1]);
        $monthly = $all / $this->getDurationInMonth();
        // Egy összesítő arról, hogy milyen adatokkal is számolunk.
        echo "
        <div class='row'>
            <table id='sum' class='ten columns offset-by-one'>
                <tr>
                <th id='center' colspan='2'>Összesítés</th>
                </tr>
                <tr>
                    <td>Felvett hitel</td>
                    <td>".number_format($this->getLoan(),0,',',' ')." Ft</td>
                </tr>
                <tr>
                    <td>Futamidő</td>
                    <td>".$this->getDurationInMonth()." hónap</td>
                </tr>
                <tr>
                    <td>Kamat</td>
                    <td>".$this->getInterestRate()."%</td>
                </tr>
                <tr>
                    <td>Összesen viszafizetendő</td>
                    <td>".number_format($all,0,',',' ')." Ft</td>
                </tr>
                <tr>
                    <td>Havi szinten törlesztendő</td>
                    <td>".number_format($monthly,0,',',' ')." Ft</td>
                </tr>
                <tr>
                    <td>Összes kamat</td>
                    <td>".number_format($this->getSumInterestRate()[$this->getDurationInMonth()-1],0,',',' ')." Ft</td>
                </tr>
            </table>
        </div>";

        //Táblázat
        echo '
            <div class="row">
            <table class="ten columns offset-by-one">
                <tr>
                    <th colspan="4">Táblázat</th>
                </tr>
                <tr>
                    <th>Hónap</th>
                    <th>Tőkemaradvány</th>
                    <th>Kamat adott hónapban</th>
                    <th>Kamat adott hónapig</th>
                </tr>';

        for ($i = 0; $i < count($this->getLoanCounter()) ; $i ++)
        {
            echo "<tr>"
            ."<td>".($i+1)."</td>"
            ."<td>".number_format($this->getLoanCounter()[$i],0,',',' ')."</td>"
            ."<td>".number_format($this->getInterestRateCounter()[$i],0,',',' ')."</td>"
            ."<td>".number_format($this->getSumInterestRate()[$i],0,',',' ')."</td>
            </tr>";
        }

        echo "</table>
        </div>";

    }
}
?>
