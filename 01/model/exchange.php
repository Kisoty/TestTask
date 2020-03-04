<?
require_once 'db.php';
Class exchange
{
    public $prev_curr, $end_curr, $amount;
    public function __construct($prev_curr, $end_curr, $amount)
    {
        $this->prev_curr = $prev_curr;
        $this->end_curr = $end_curr;
        $this->amount = $amount;
    }
    public function transform ()
    {
        $DBobj = new DB();
        $eurToPrevCoeff = $DBobj->selectCurr($this->prev_curr);
        $eurToEndCoeff = $DBobj->selectCurr($this->end_curr);
        $ans = $this->amount*$eurToEndCoeff/$eurToPrevCoeff;
        $DBobj = null;
        return $ans;
    }
}