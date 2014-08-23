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
        global $week;
        global $date;
        global $year;
        if ($this->mode == 2) {
            $tbl_name = $this->user->getName() . "_planer";
            echo '<h2 class="sub-header"> Planer ' . $this->user->getName() . ' (' . $week . '. Kalenderwoche) </h2>
        <div class="table-responsive">
        <table class="table table-striped">
        <thead>
        <tr>
        <th>Zeit</th>
        <th>Montag</th>
        <th>Dienstag</th>
        <th>Mittwoch</th>
        <th>Donnerstag</th>
        <th>Freitag</th>
        </tr>
        </thead>
        <tbody>';
            try {
                $sql = "SELECT * FROM `" . $tbl_name . "`s ORDER BY Zeit, Tag";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stamp = getStampFromWeek($week, $year);
                $montag = date('Y-m-d', $stamp);
                $dienstag = date('Y-m-d', $stamp + 24 * 60 * 60);
                $mittwoch = date('Y-m-d', $stamp + 24 * 60 * 60 * 2);
                $donnerstag = date('Y-m-d', $stamp + 24 * 60 * 60 * 3);
                $freitag = date('Y-m-d', $stamp + 24 * 60 * 60 * 4);
                $lasttime = 0;
                $setMontag = 0;
                $setDienstag = 0;
                $setMittwoch = 0;
                $setDonnerstag = 0;
                $setFreitag = 0;
                $firstRun = 1;
                foreach ($results as $row) {
                    array_walk_recursive($row, 'encode_items');
                    if( $row['Zeit'] == $montag || $row['Zeit'] == $dienstag || $row['Zeit'] == $mittwoch || $row['Zeit'] == $donnerstag || $row['Zeit'] == $freitag)
                    if ($lasttime != $row['Zeit'] && !$firstRun) {
                        echo '</tr><tr> ';
                        echo '<td>' . $row['Zeit'] . '</td>';
                        $setMontag = 0;
                        $setDienstag = 0;
                        $setMittwoch = 0;
                        $setDonnerstag = 0;
                        $setFreitag = 0;
                        $lasttime = $row['Zeit'];
                    }


                    if($firstRun){
                        echo '</tr><tr> ';
                        echo '<td>' . $row['Zeit'] . '</td>';
                        $lasttime = $row['Zeit'];
                        $firstRun = 0;
                    }


                    if ($row['Tag'] == $montag && $setMontag != 1) {
                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $setMontag = 1;
                    } elseif ($row['Tag'] == $dienstag && $setDienstag != 1) {
                        if ($setMontag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMontag = 1;
                        }
                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $setDienstag = 1;
                    } elseif ($row['Tag'] == $mittwoch && $setMittwoch != 1) {
                        if ($setMontag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMontag = 1;
                        }
                        if ($setDienstag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setDienstag = 1;
                        }
                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $setMittwoch = 1;
                    } elseif ($row['Tag'] == $donnerstag && $setDonnerstag != 1) {
                        if ($setMontag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMontag = 1;
                        }
                        if ($setDienstag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setDienstag = 1;
                        }
                        if ($setMittwoch == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMittwoch = 1;
                        }
                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $setDonnerstag = 1;
                    } elseif ($row['Tag'] == $freitag && $setFreitag != 1) {
                        if ($setMontag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMontag = 1;
                        }
                        if ($setDienstag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setDienstag = 1;
                        }
                        if ($setMittwoch == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setMittwoch = 1;
                        }
                        if ($setDonnerstag == 0 && $lasttime == $row['Zeit']) {
                            echo '<td></td>';
                            $setDonnerstag = 1;
                        }
                        echo '<td>' . $row['Inhalt'] . '</td>';
                        $setFreitag = 1;
                    } else
                        echo '<td></td>';

                    $lasttime = $row['Zeit'];

                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo '</tbody>
        </table>
        </div>';
        } elseif ($this->mode == 1) {
            $tbl_name = $this->user->getClass() . "_stundenplan";
            echo '<h2 class="sub-header"> Vertretungsplan ' . $this->user->getClass() . ' (' . $week . '. Kalenderwoche) </h2>
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
            try {
                $sql = "SELECT * FROM `" . $tbl_name . "`s";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stamp = getStampFromWeek($week, $year);
                $montag = date('Y-m-d', $stamp);
                $dienstag = date('Y-m-d', $stamp + 24 * 60 * 60);
                $mittwoch = date('Y-m-d', $stamp + 24 * 60 * 60 * 2);
                $donnerstag = date('Y-m-d', $stamp + 24 * 60 * 60 * 3);
                $freitag = date('Y-m-d', $stamp + 24 * 60 * 60 * 4);
                $tbl_name2 = $this->user->getClass() . "_vertretung";
                $sql2 = "SELECT * FROM `" . $tbl_name2 . "`s";
                $stmt2 = $this->pdo->prepare($sql2);
                $stmt2->execute();
                $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row) {
                    array_walk_recursive($row, 'encode_items');
                    echo '<tr> ';
                    echo '<td>' . $row['Stunde'] . '</td>';
                    echo '<td>' . $row['Zeit'] . '</td>';
                    echo '<td>' . $row['Montag'];
                    foreach ($results2 as $row2) {
                        if (array_key_exists('Tag', $row2)) {
                            if ($row2['Tag'] == $montag) {
                                if ($row['Stunde'] == $row2['Stunde']) {
                                    if (!$row2['Entfall'])
                                        echo '</br> <div id="vertretung">' . $row2['Fach'] . '</br>' . $row2['Lehrer'] . '</br>' . $row2['Anmerkung'] . ' </div></br>';
                                    else
                                        echo '</br> <div id="entfall"> Entfall </div>';
                                }
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $row['Dienstag'];
                    foreach ($results2 as $row2) {
                        if (array_key_exists('Tag', $row2)) {
                            if ($row2['Tag'] == $dienstag) {
                                if ($row['Stunde'] == $row2['Stunde']) {
                                    if (!$row2['Entfall'])
                                        echo '</br> <div id="vertretung">' . $row2['Fach'] . '</br>' . $row2['Lehrer'] . '</br>' . $row2['Anmerkung'] . ' </div></br>';
                                    else
                                        echo '</br> <div id="entfall"> Entfall </div>';
                                }
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $row['Mittwoch'];
                    foreach ($results2 as $row2) {
                        if (array_key_exists('Tag', $row2)) {
                            if ($row2['Tag'] == $mittwoch) {
                                if ($row['Stunde'] == $row2['Stunde']) {
                                    if (!$row2['Entfall'])
                                        echo '</br> <div id="vertretung">' . $row2['Fach'] . '</br>' . $row2['Lehrer'] . '</br>' . $row2['Anmerkung'] . ' </div></br>';
                                    else
                                        echo '</br> <div id="entfall"> Entfall </div>';
                                }
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $row['Donnerstag'];
                    foreach ($results2 as $row2) {
                        if (array_key_exists('Tag', $row2)) {
                            if ($row2['Tag'] == $donnerstag) {
                                if ($row['Stunde'] == $row2['Stunde']) {
                                    if (!$row2['Entfall'])
                                        echo '</br> <div id="vertretung">' . $row2['Fach'] . '</br>' . $row2['Lehrer'] . '</br>' . $row2['Anmerkung'] . ' </div></br>';
                                    else
                                        echo '</br> <div id="entfall"> Entfall </div>';
                                }
                            }
                        }
                    }
                    echo '</td>';
                    echo '<td>' . $row['Freitag'];
                    foreach ($results2 as $row2) {
                        if (array_key_exists('Tag', $row2)) {
                            if ($row2['Tag'] == $freitag) {
                                if ($row['Stunde'] == $row2['Stunde']) {
                                    if (!$row2['Entfall'])
                                        echo '</br> <div id="vertretung">' . $row2['Fach'] . '</br>' . $row2['Lehrer'] . '</br>' . $row2['Anmerkung'] . ' </div></br>';
                                    else
                                        echo '</br> <div id="entfall"> Entfall </div>';
                                }
                            }
                        }
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo '</tbody>
        </table>
        </div>';
        } elseif ($this->mode == 0) {
            $tbl_name = $this->user->getClass() . "_stundenplan";
            echo '<h2 class="sub-header"> Stundenplan ' . $this->user->getClass() . ' (' . $week . '. Kalenderwoche) </h2>
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
            try {
                $sql = "SELECT * FROM `" . $tbl_name . "`s";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) {
                    array_walk_recursive($row, 'encode_items');
                    echo '<tr>
				<td>' . $row['Stunde'] . '</td>
				<td>' . $row['Zeit'] . '</td>
				<td>' . $row['Montag'] . '</td>
				<td>' . $row['Dienstag'] . '</td>
				<td>' . $row['Mittwoch'] . '</td>
				<td>' . $row['Donnerstag'] . '</td>
				<td>' . $row['Freitag'] . '</td></tr>';
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo '</tbody>
        </table>
        </div>';
        }
    }

}

?>