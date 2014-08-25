<?php

class Calendar
{
    private $user = '';
    private $mode = '';
    private $pdo = null;

    public function __construct($pdo, $user, $mode)
    {
        $this->pdo = $pdo;
        $this->user = $user;
        $this->mode = $mode;
    }

    public function show()
    {
        global $zeiten;
        global $week;
        global $date;
        global $year;

        $stamp = getStampFromWeek($week, $year);
        $days = array();

        for ($i = 0; $i < 5; $i++)
            $days[] = array("weekday" => strftime('%A', $stamp + 24 * 60 * 60 * $i),"pretty" => strftime('%A, %d.%m.', $stamp + 24 * 60 * 60 * $i), "date" => strftime('%Y-%m-%d', $stamp + 24 * 60 * 60 * $i));

        $tbl_name_class = $this->user->getClass() . "_planer";
        $tbl_name_user = $this->user->getName() . "_planer";
        $tbl_name_timetable = $this->user->getClass() . "_stundenplan";
        $tbl_name_vpl = $this->user->getClass() . "_vertretung";


        switch ($this->mode) {
            case 0:
            case 1:
                echo '<h2 class="sub-header">';

                if ($this->mode == 0)
                    echo 'Stundenplan ' . $this->user->getClass() . ' (' . $week . '. Kalenderwoche)';
                else
                    echo 'Vertretungsplan ' . $this->user->getClass() . ' (' . $week . '. Kalenderwoche)';

                echo '</h2>
        <div class="table-responsive">
        <table class="table table-striped">
        <thead>
        <tr>
        <th>Stunde</th>
        <th>Zeit</th>';

                foreach ($days as $day)
                    echo '<th>' . $day["pretty"] . '</th>';

                echo '</tr>
        </thead>
        <tbody>';
                try {
                    $sql = "SELECT s.Stunde as Stunde, s.Tag as Tag, s.Fach as Fach, v.Fach as FachVpl, v.Lehrer as Lehrer, v.Anmerkung as Anmerkung, v.Entfall as Entfall FROM `{$tbl_name_timetable}` as s LEFT JOIN (SELECT * FROM `{$tbl_name_vpl}` WHERE WEEKOFYEAR(Tag) = {$week} AND YEAR(Tag) = {$year}) as v ON (s.Stunde = v.Stunde AND s.Tag = DAYOFWEEK(v.Tag)) ORDER BY s.Stunde, s.Tag";

                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $estNext = 0;
                    $lasttime = -1;

                    foreach ($results as $row) {
                        array_walk_recursive($row, 'encode_items');

                        if ($lasttime != $row['Stunde']) {
                            if ($lasttime != -1)
                                echo '</tr>';
                            echo '<tr> ';
                            echo '<td>' . $row['Stunde'] . '</td>';
                            echo '<td>' . $zeiten[$row['Stunde'] - 1] . '</td>';
                        }
                        $lasttime = $row['Stunde'];

                        echo '<td>' . $row["Fach"];

                        if ($this->mode == 1) {
                            if ($row['Entfall'] === null)
                                echo "</td>";
                            else if ($row['Entfall'] == 1)
                                echo '<br /> <div id="entfall"> Entfall </div></td>';
                            else
                                echo '<br /> <div id="vertretung">' . $row['FachVpl'] . '</br>' . $row['Lehrer'] . '<br />' . $row['Anmerkung'] . ' </div></td>';
                        }
                    }

                    if (count($results) > 0)
                        echo '</tr>';
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                echo '</tbody>
        </table>
        </div>';
                break;
            case 2:
            case 3:
            case 4:


                echo '<h2 class="sub-header"> Aufgaben ';

                switch ($this->mode) {
                    case 2:
                        echo $this->user->getName();
                        $sql = "SELECT Zeit, Tag, GROUP_CONCAT(Inhalt SEPARATOR '\n') as Inhalt FROM (SELECT * FROM `" . $tbl_name_user . "`s) as a  GROUP BY Zeit, Tag ORDER BY Zeit, Tag;";
                        break;
                    case 3:
                        echo $this->user->getClass();
                        $sql = "SELECT Zeit, Tag, GROUP_CONCAT(Inhalt SEPARATOR '\n') as Inhalt FROM (SELECT * FROM `" . $tbl_name_class . "`s) as a  GROUP BY Zeit, Tag ORDER BY Zeit, Tag;";
                        break;
                    case 4:
                        echo $this->user->getName() . ' / ' . $this->user->getClass();
                        $sql = "SELECT Zeit, Tag, GROUP_CONCAT(Inhalt SEPARATOR '\n') as Inhalt FROM ((SELECT * FROM `" . $tbl_name_class . "`s) UNION (SELECT * FROM `" . $tbl_name_user . "`s)) as a  GROUP BY Zeit, Tag ORDER BY Zeit, Tag;";
                        break;
                }

                echo ' (KW. ' . $week . ') </h2>
        <div class="table-responsive">
        <table class="table table-striped">
        <thead>
        <tr>
        <th>Zeit</th>';
                foreach ($days as $day)
                    echo '<th>' . $day["pretty"] . '</th>';
                echo '</tr>
        </thead>
        <tbody>';
                try {
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute();

                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    $lasttime = 0;

                    $estNext = 0;

                    foreach ($results as $row) {
                        array_walk_recursive($row, 'encode_items');

                        $next = -1;

                        for ($i = 0; $i < 5; $i++) {
                            if ($days[$i]["date"] == $row['Tag']) {
                                $next = $i;
                                break;
                            }
                        }

                        if ($next == -1)
                            continue;

                        if ($lasttime != $row['Zeit']) {
                            echo '</tr><tr> ';
                            echo '<td>' . $row['Zeit'] . '</td>';
                            $estNext = 0;
                            $lasttime = $row['Zeit'];
                        }

                        while ($estNext < $next) {
                            echo '<td></td>';
                            $estNext++;
                        }

                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $estNext++;

                        $lasttime = $row['Zeit'];
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                echo '</tbody>
        </table>
        </div>';

                break;
        }
    }

}

?>