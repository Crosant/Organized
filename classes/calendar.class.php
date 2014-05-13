<?php
class Calendar
{
	private $user = '';
	private $mode = '';
	
	public function __construct($user, $mode)
	{
		$this->user = $user;
		$this->mode = $mode;
	}
	
	public function show()
	{
		if($this->mode == 1)
		{
        $tbl_name=$this->user->getClass() ."_Vertretung";
        echo '<h2 class="sub-header"> Vertretungsplan '. $this->user->getClass() .' vom '. $datum . ' </h2>
        <div class="table-responsive">
        <table class="table table-striped">
        <thead>
        <tr>
        <th>Stunde</th>
        <th>Fach</th>
        <th>Raum</th>
        <th>Lehrer</th>
        <th>Bemerkung</th>
        </tr>
        </thead>
        <tbody>
        
        </tbody>
        </table>
        </div>';
		}
    elseif ($this->mode == 0)
	{
        $tbl_name=$this->user->getClass() ."_stundenplan";
        echo '<h2 class="sub-header"> Stundenplan '. $this->user->getClass() .' ('. $woche . ' </h2>
        <div class="table-responsive">
        <table class="table table-striped">
        <thead>
        <tr>
        <th>Stunde</th>
        <th>Zeit</th>
        <th>Montag</th>
        <th>Dienstag</th>
        <th>Mittwoch</th>
        <th>Donnerstag</th>
        <th>Freitag</th>
        </tr>
        </thead>
        <tbody>';
        try{
			$sql = "SELECT * FROM `".$tbl_name."`s";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($results as $row){
				array_walk_recursive($row, 'encode_items');
				echo '<tr> <td>'.$row['Stunde'].'</td><td>'.$row['Zeit'].'</td><td>'. $row['Montag'] .'</td><td>'. $row['Dienstag'] .'</td><td>'.$row['Mittwoch'].'</td><td>'.$row['Donnerstag'].'</td><td>'.$row['Freitag'].'</td></tr>';
			}
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        echo '</tbody>
        </table>
        </div>';
		}
	}
	
}
?>