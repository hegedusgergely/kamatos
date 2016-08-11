<?php

/**
 * This Class is responsible for printing out the resoults.
 */

namespace Kamatos;

class PrintOut
{
    protected $count;

    public function __construct(Count $count)
    {
        $this -> count = $count;

        // var_dump($count);
        $this -> __toString();
    }

    public function __toString()
    {
        /**
         * Summary of the values we are working with. Just to be sure.
         */
        echo "
        <div class='container'>
            <div class='row'>
                <p class='ten columns offset-by-one'>
                    A felvett hitel összege
                    <strong>".number_format($count -> getLoan(),0,',',' ')."</strong> Ft,
                    <strong>".$this -> getDuration()."</strong> hónapra <strong>"
                    .$this -> getInterest()."</strong>%-os kamattal.
                    <br>
                </p>
            </div>
        </div>";

        /**
         * These are the end results. If the user wants to see detailed info, scroll down.
         */
        // $all = ($this -> getLoan() + $this -> getSumInterest()[$this -> getDuration()-1]);
        // $monthly = $all / $this -> getDuration();
        // echo "
        // <div class='row'>
        //     <p class='eight columns offset-by-two'>
        //         Összesen visszavizetendő: <strong>".number_format($all,0,',',' ')
        //         .'</strong> Ft ami havonta: <strong>'.number_format($monthly,0,',',' ').'</strong> Ft.
        //     </p>
        // </div>';

        /**
         * Table
         */
        // echo '
        //     <div class="row">
        //     <table class="ten columns offset-by-one">
        //         <tr>
        //             <th>Hónap</th>
        //             <th>Tőkemaradvány</th>
        //             <th>Kamat adott hónapban</th>
        //             <th>Kamat adott hónapig</th>
        //         </tr>';
        //
        // for ($i = 0; $i < count($this -> getLoanCounter()) ; $i ++)
        // {
        //     echo "<tr>"."<td>".($i+1)."</td>"
        //     ."<td>".number_format($this -> getLoanCounter()[$i],0,',',' ')."</td>"
        //     ."<td>".number_format($this -> getInterestCounter()[$i],0,',',' ')."</td>"
        //     ."<td>".number_format($this -> getSumInterest()[$i],0,',',' ')."</td></tr>";
        // }
        //
        // echo "</table>
        // </div>";
    }
}
?>
