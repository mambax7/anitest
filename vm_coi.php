<?php

use Xmf\Request;

error_reporting(0);
require_once __DIR__ . '/../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/animal/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/animal/language/english/templates.php';
}
require_once XOOPS_ROOT_PATH . '/modules/animal/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'pedigree_coi.tpl';
include XOOPS_ROOT_PATH . '/header.php';

if (!isset($moduleDirName)) {
    $moduleDirName = basename(__DIR__);
}

//get module configuration
/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($moduleDirName);
$configHandler = xoops_getHandler('config');
$moduleConfig  = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

global $xoopsTpl, $xoopsDB, $moduleConfig;
?>
<!--<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function () {


        $('#gotoback').click(function () {
            document.location = 'virtual.php';

        });
        $('#gotoback1').click(function () {
            document.location = 'virtual.php';

        });


    });
</script>
<?php
//start kinship.php code -- help !!
/* ************************************************************************************* */
/*
     This program calculates the coefficient of inbreeding (IC, or COI, or F)
     for the offspring of a couple of animals, given by their IDs (s=sire_ID&d=dam_ID),
     or for a given animal given by its ID (a=animal_ID).

     By default, all known ascendants are used.
     However, maximum count of distinct ascendants is limited to $nb_maxi (default=600)
              [higher values for $nb_maxi could lead to calculations ending in timeout],
              or depth of tree can be limited to $nb_gen generations (default = 8).
*/
/* ************************************************************************************* */

if (!isset($verbose)) {
    $verbose = 0;
}   // don't display different steps of ICs calculation
//if (!isset($detail)) {
if (empty($detail)) {
    $detail = 1;
}   // don't display detail results [faster]
if (!isset($nb_maxi)) {
    $nb_maxi = 600;
}   // maximum count of distinct ascendants
if (!isset($nb_gen)) {
    $nb_gen = 8;
}   // maximum count of generations of ascendants
if (!isset($pedigree)) {
    $pedigree = 0;
}   // dont't display sketch pedigree [faster]
if (!isset($max_dist)) {                     // maximum length of implex loops
    if ($nb_gen > 9) {
        $max_dist = 14;
    } elseif ($nb_gen == 9) {
        $max_dist = 17;
    } elseif ($nb_gen == 8) {
        $max_dist = 18;
    } else {
        $max_dist = 99;
    }
}

$empty = array(); // an empty array
$sql1  = 'SELECT ID, vader, moeder, roft FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE ID ';
//$sql1  = 'SELECT ID, vader, moeder, roft FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom');
//echo $unamefetch="select ID, vader, moeder, roft from ".$GLOBALS['xoopsDB']->prefix("stamboom")." WHERE ID='".$_SESSION['xoopsUserId']."'";

// input data arrays:
$IDs = $empty;
$fathers = $empty;
$mothers = $empty;

// working arrays:
$inds    = $empty;
$marked  = $empty;
$ICknown = $empty;
$deltaf  = $empty;
$pater   = $empty;
$mater   = $empty;
$chrono  = $empty;

// Coefficients of Inbreeding array (result):
$COIs = $empty;

/* ******************************  FUNCTIONS  ********************************* */

/**
 * @return int
 */
function chrono_sort()
{
    global $IDs, $inds, $fathers, $mothers, $chrono, $nl, $detail;
    $impr  = 0;
    $modif = 1;
    $nloop = 0;
    $nba   = count($IDs);
    //print_r ($IDs) ;
    // echo "<b>231 : $IDs[231] $fathers[231] $mothers[231] $chrono[231] $inds[231] </b><br>\n" ;
    foreach ($IDs as $i => $v) {
        $chrono[$i] = 1;
    }
    //echo "80"; print_r($IDs);
    // initialize all chronological ranks to 1
    $chrono[0] = 0;                            // except animal #0 (at 0 rank).
    while ($modif && $nloop < 40) {
        $modif = 0;
        ++$nloop;
        for ($i = 1; $i < $nba; ++$i) {
            $s = $fathers[$i];
            if ($s) {
                $s = $inds[$s];
            }
            $d = $mothers[$i];
            if ($d) {
                $d = $inds[$d];
            }
            if ($s && $chrono[$s] <= $chrono[$i]) {
                $chrono[$s] = $chrono[$i] + 1;
                $modif      = 1;
            }
            if ($d && $chrono[$d] <= $chrono[$i]) {
                $chrono[$d] = $chrono[$i] + 1;
                $modif      = 1;
            }
        }
    }
    if ($nloop == 40) {
        die('Endless loop detected. Stopped.');
    }
    array_multisort($chrono, $IDs, $fathers, $mothers);
    $depth = $chrono[$nba - 1];
    //commentes out by JC
    //if ($detail) echo "<br>Chronological ranking done : Pedigree stretched over <b>$depth</b> generations.<br>$nl" ;
    if ($impr) {
        echo "</center><pre>$nl $nl";
        foreach ($chrono as $i => $val) {
            echo "<b>$i</b> : $val $IDs[$i] $fathers[$i] $mothers[$i] $nl";
        }
        echo "</pre>$nl";
        die('</html>');
    }
    $inds = array_flip($IDs);

    return 0;
}

/**
 * @param $s
 *
 * @return array
 */
function fetch_record($s)
{
    global $database;
    $r = $GLOBALS['xoopsDB']->queryF($s);
    $n = 0;
    if ($r) {
        $n = $GLOBALS['xoopsDB']->getRowsNum($r);
    }
    if ($n == 0) {
        $record = array('0');
    } else {
        $record = $GLOBALS['xoopsDB']->fetchBoth($r);
    }

    return $record;
}

/**
 * @param $ind
 * @param $gen
 *
 * @return int
 */
function count_all($ind, $gen)
{
    global $inds, $nb_gen, $nb_all, $fathers, $mothers;
    if ($ind) {
        ++$nb_all;
    }
    $s = $fathers[$ind];
    $d = $mothers[$ind];
    if ($s && $gen < $nb_gen) {
        count_all($s, $gen + 1);
    }
    if ($d && $gen < $nb_gen) {
        count_all($d, $gen + 1);
    }

    return 0;
}

/**
 * @param $ch
 * @param $niv
 *
 * @return int
 */
function add_multi($ch, $niv)
{
    global $implx, $couls, $nl;
    reset($implx);
    $first = 1;
    foreach ($implx as $im => $impl) {
        if ($impl[0] == $ch || $impl[1] == $ch) {
            if ($niv > 1 && $first) {
                echo "<br>$nl";
            } else {
                echo '&nbsp;&nbsp;&nbsp;';
            }
            $i     = $im + 1;
            $j     = min($im, 6);
            $c     = $couls[$j];
            $first = 0;
            echo '<font color=' . $c . ' size="+2"><b>*' . $i . '*</b></font>';
        }
    }

    return 0;
}

/**
 * @param $ind
 * @param $gen
 * @param $class
 *
 * @return int
 */
function output_animal($ind, $gen, $class)
{
    global $depth, $IDs, $fathers, $mothers, $nl;
    if ($gen > $depth) {
        return 0;
    }
    $cell_content = '&Oslash;';
    if ($ind || $gen == 0) {
        $ID           = $IDs[$ind];
        $ani          = set_name($ID);
        $name         = $ani[1];
        $name         = $ID;
        $cell_content = showparent($name) . $nl;
    }
    $rowspan = 1 << ($depth - $gen);
    echo '<td rowspan=' . $rowspan . ' align="center" class="' . $class . '">' . $cell_content . "</td>$nl";
    if ($gen < $depth) {
        $sire = 0;
        if ($ind || $gen == 0) {
            $sire = $fathers[$ind];
        }
        output_animal($sire, $gen + 1, '0');
        $dam = 0;
        if ($ind || $gen == 0) {
            $dam = $mothers[$ind];
        }
        output_animal($dam, $gen + 1, '1');
    } else {
        echo "</tr><tr>$nl";
    }

    return 0;
}

/**
 * @return int
 */
function SKETCH_PEDIGREE()
{
    global $nl, $detail, $depth, $IDs;
    // print_r ($IDs) ;
    echo $nl
         . '<br>'
         . $nl
         . '<table border="3" cellpadding="4" width="85%"" cellpadding="0" cellspacing="0">'
         . $nl
         . '<tr><th colspan="10" align="center">SKETCH &nbsp; PEDIGREE &nbsp; OF COMMON PROGENY</th></tr>'
         . $nl
         . '<tr align="center" valign="middle"><th>Progeny</th><th>'
         . _('Sire / Dam')
         . '</th>';
    if ($depth >= 2) {
        echo '<th>' . _('Grandparents') . '</th>' . $nl;
    }
    if ($depth >= 3) {
        echo '<th>' . _('Great-Grandparents') . '</th>' . $nl;
    }
    if ($depth >= 4) {
        echo '<th>3xGr. P.</th>' . $nl;
    }
    if ($depth >= 5) {
        echo '<th>4xGr. P.</th>' . $nl;
    }
    if ($depth >= 6) {
        echo '<th>5xGr. P.</th>' . $nl;
    }
    if ($depth >= 7) {
        echo '<th>6xGr. P.</th>' . $nl;
    }
    echo '</tr><tr>';
    output_animal(0, 0, '0');  /* output the sketch pedigree */
    echo $nl . '</tr></table>' . $nl . '<p />' . $nl;

    return 0;
}

/**
 * @return int
 */
function GENEALOGY()
{
    global $IDs, $fathers, $mothers, $inds, $nb_gen, $nb_maxi, $nbani, $nl, $sql1;
    $impr       = 0;
    $fathers[0] = $IDs[1];
    $mothers[0] = $IDs[2];
    $fathers[1] = 0;
    $mothers[1] = 0;
    $fathers[2] = 0;
    $mothers[2] = 0;
    $last       = 2;
    if ($impr) {
        echo "<!-- genealogy 'de cujus' (gener. 0) : $IDs[0] = $IDs[1] x $IDs[2] -->$nl";
    }
    $generation = array($IDs[1], $IDs[2]);  // starting with first generation (sire and dam)
    $nbtot      = 0;    // count of total known ascendants within $nb_gen generations
    for ($nloop = 1, $tot = 2; $last <= $nb_maxi && $nloop <= $nb_gen; $nloop++) {
        $nbtot      += $tot;    // count of total known ascendants within $nb_gen generations
        $nbani      = $last;    // count of    distinct ascendants within $nb_gen generations
        $list       = implode(',', array_unique($generation));
        $generation = array();
        $tot        = 0;
        if ($impr) {
            echo "    [$list]$nl";
        }

        // HERE IS FETCHED EACH TRIPLET [ID, sire_ID, dam_ID] :
        $r = $GLOBALS['xoopsDB']->queryF("$sql1 IN ($list)");
        while ($rec = $GLOBALS['xoopsDB']->fetchBoth($r)) {
            $a = $rec[0] + 0;
            $s = $rec[1] + 0;
            $d = $rec[2] + 0;
            if (!isset($a)) {
                echo "ERROR : $a = $s x $d for list = '$list'<br>\n";
            }
            if ($s) {
                ++$tot;
            }
            if ($d) {
                ++$tot;
            }
            $j           = array_keys($IDs, $a);
            $j           = $j[0];
            $fathers[$j] = $s;
            $mothers[$j] = $d;
            if ($s && !in_array($s, $IDs)) {
                $i           = ++$last;
                $IDs[$i]     = $s;
                $fathers[$i] = 0;
                $mothers[$i] = 0;
                if ($s) {
                    $generation[] = $s;
                }
            }
            if ($d && !in_array($d, $IDs)) {
                $i           = ++$last;
                $IDs[$i]     = $d;
                $fathers[$i] = 0;
                $mothers[$i] = 0;
                if ($s) {
                    $generation[] = $d;
                }
            }
            if ($impr) {
                echo "<pre>genealogy ascendant (gener. $nloop) : $a = $s x $d  [tot = $tot]$nl</pre>";
            }
        }
        if (!count($generation)) {
            break;
        }
    }

    if ($nloop <= $nb_gen) {
        $nb_gen = $nloop;
    }  // tree cut by $nb_maxi !

    reset($IDs);
    $inds = array_flip($IDs);

    chrono_sort();

    return $nbtot;
}

/**
 * @param $p
 * @return int
 */
function dist_p($p)
{
    global $IDs, $fathers, $mothers, $pater, $nb_gen, $detail, $nl;
    // Anim #P is the sire
    $listall   = array($p);
    $listnew   = array($p);
    $pater     = array();
    $pater[$p] = 1;
    for ($nloop = 2; $nloop < ($nb_gen + 1); ++$nloop) {
        $liste = array();
        foreach ($listnew as $i) {
            $s = $fathers[$i];
            $d = $mothers[$i];
            if ($s && !$pater[$s]) {
                $pater[$s] = $nloop;
            } // least distance from $s to sire's progeny
            if ($d && !$pater[$d]) {
                $pater[$d] = $nloop;
            } // least distance from $d to sire's progeny
            if ($s) {
                $liste[] = $s;
            }
            if ($d) {
                $liste[] = $d;
            }
        }
        if (!count($liste)) {
            break;
        }
        //commented pout by jc
        //if (in_array ($IDs[2], $liste) && !$detail)
        //{ echo "<p>DAM is an ascendant (at $nloop generations) of SIRE.  Stopped." ;
        // die ("</body></html>$nl") ; }
        $listnew = array_diff(array_unique($liste), $listall);
        /* $list1 = join (' ', $listall) ; $list2 = join ('+', $listnew) ;
             echo "<!-- P ($nloop) $list1/$list2 -->$nl" ; */
        $listall = array_merge($listall, $listnew);
    }
    // Here $pater array contains list of all distinct ascendants of #P (including P himself)
    // Values of $pater are minimum distances to #P (in generations) +1
    return 0;
}

/**
 * @param $m
 *
 * @return int
 */
function dist_m($m)
{
    global $IDs, $fathers, $mothers, $mater, $nb_gen, $detail, $nl;
    // Anim #M is the dam
    $listall   = array($m);
    $listnew   = array($m);
    $mater     = array();
    $mater[$m] = 1;
    for ($nloop = 2; $nloop <= ($nb_gen + 1); ++$nloop) {
        $liste = array();
        foreach ($listnew as $i) {
            $s = $fathers[$i];
            $d = $mothers[$i];
            if ($s && !isset($mater[$s])) {
                $mater[$s] = $nloop;
            } // least distance from $s to dam's progeny
            if ($d && !isset($mater[$d])) {
                $mater[$d] = $nloop;
            } // least distance from $d to dam's progeny
            //echo "I=" . $i . " MATER(I)=" . $mater[$i] . " NLOOP=" . $nloop . "<br>$nl" ;
            if ($s) {
                $liste[] = $s;
            }
            if ($d) {
                $liste[] = $d;
            }
        }
        if (!count($liste)) {
            break;
        }
        //commented out by jc
        //if (in_array ($IDs[1], $liste) && !$detail)
        // { echo "<p>SIRE is an ascendant (at $nloop generations) of DAM.  Stopped." ;
        //  die ("</body></html>$nl") ; }
        $listnew = array_diff(array_unique($liste), $listall);
        // $list1 = join (' ', $listall) ; $list2 = join ('+', $listnew) ; echo "M ($nloop) $list1/$list2 $nl" ;
        $listall = array_merge($listall, $listnew);
    }
    // Here $mater array contains list of all distinct ascendants of #M (including M herself)
    // Values of $mater are minimum distances to #M (in generations) +1
    return 0;
}

/**
 * @return array
 */
function calc_dist()       /* Common Ascendants and their distances */
{
    global $IDs, $fathers, $mothers, $nbanims, $pater, $mater, $empty, $nb_gen, $nl;
    global $dmax, $detail, $nb_gen;
    $distan = array();
    // dist_m (2) ;   has already been called
    dist_p($fathers[0]);
    $dmax = 0;
    $impr = 0;
    $dmx  = 7;
    //if (null !== $detail) {
    if ($detail) {
        $dmx += 2;
    }
    // ksort ($pater) ; print_r ($pater) ; echo "<br>$nl" ; ksort ($mater) ; print_r ($mater) ; echo "<br>$nl" ;
    foreach ($pater as $i => $p) {
        if ($p) {
            $m = $mater[$i];
            if ($m) {
                $di = $p + $m;
                if ($impr) {
                    echo " $i : $p + $m = $di <br>$nl";
                }
                if (!$dmax) {
                    $dmax = $dmx + $di - ceil($di / 2.);
                }
                if ($di > ($dmax + 2)) {
                    continue;
                }
                $distan[$i] = $di;
            }
        }
    }
    if (!$dmax) {
        $dmax = 2 * $nb_gen - 2;
    }

    return $distan;
}

/**
 * @param $p
 * @param $m
 * @param $a
 * @param $ndist
 *
 * @return int
 */
function mater_side($p, $m, $a, $ndist)
{
    global $fathers, $mothers, $marked, $COIs, $deltaf, $ICknown, $verbose, $nl, $chrono, $paternal_rank, $max_dist;
    $already_known = '';
    if (!$m || $ndist > $max_dist) {
        return 0;
    }
    if ($p == $m) {
        /* IMPLEX FOUND (node of consanguinity) for Anim #A */
        $already_known = $ICknown[$p];
        //}
        if (!$already_known) {
            CONSANG($p);
        }  // MAIN RECURSION:
        $ICp = isset($COIs[$p]) ? $COIs[$p] : 0;                    // we need to know the IC of Parent for Wright's formula
        if ($verbose && !$already_known && $ICp > 0.001 * $verbose) {
            echo "IC of Animal $p is $ICp$nl";
        }

        $incr = 1.0 / (1 << $ndist) * (1. + $ICp);    // ******** applying WRIGHT's formula ********
        // [Note:  1 << $ndist is equal to 2 power $ndist]

        //echo ' ---- $a= ' . $a . ' <br>';
        //echo ' ---- $incr= ' . $incr . ' <br>';
        //echo ' $COIs[$a]= ' . $COIs[$a] . ' <br>';
        if (!isset($COIs[$a])) {
            $COIs[$a] = 0;
        }
        $COIs[$a] += $incr;  // incrementing the IC of AnimC

        if ($a == 0) {
            $deltaf[$p] += $incr;
        }
        /* contribution of Anim #P to IC of Anim #0 */
        // if ($verbose && $a == 0 && $incr > 0.0001*$verbose){
        //    echo "Animal $p is contributing for " . substr ($deltaf[$p], 0, 10) . " to the IC of Animal $a$nl" ;
    } else {
        if (!$marked[$m] && $chrono[$m] < $paternal_rank) {
            mater_side($p, $fathers[$m], $a, $ndist + 1);
            mater_side($p, $mothers[$m], $a, $ndist + 1);
        }
    }

    return 0;
}

/**
 * @param $p
 * @param $m
 * @param $a
 * @param $pdist
 * @return int
 */
function pater_side($p, $m, $a, $pdist)
{
    global $mater, $fathers, $mothers, $marked, $chrono, $paternal_rank;
    if (!$p) {
        return 0;
    }
    $paternal_rank = $chrono[$p];
    $marked[$p]    = 1;      /* cut paternal side */
    if (isset($mater[$p]) || $a) {
        mater_side($p, $m, $a, $pdist);
    }
    pater_side($fathers[$p], $m, $a, $pdist + 1);
    pater_side($mothers[$p], $m, $a, $pdist + 1);
    $marked[$p] = 0;     /* free paternal side */

    return 0;
}

/**
 * @param $a
 *
 * @return int
 */
//function CONSANG($a)
function CONSANG($a = null)
{
    global $fathers, $mothers, $ICknown, $COIs, $nl, $verbose;
    // if (!$a || $ICknown[$a]) {
    if (!isset($a) || ($a > -1 && $ICknown[$a])) {
        return 0;
    }
    if ($a == -1) {
        $a = 0;
    }  // particular case : a= -1 means Anim #0 (to bypass above test)
    $IC_if_deadend = 0.0;  // 0.0 means that deadends are deemed to be total outcrosses...
    // if IC was already stored in the database for Aminal #A, it should be used here instead of 0.0
    $p = $fathers[$a];
    $m = $mothers[$a];
    if (!$p || !$m) {
        $COIs[$a]    = $IC_if_deadend;
        $ICknown[$a] = 2;

        return 0;
    }

    if ($verbose) {
        echo "</center><pre>$nl";
    }
    pater_side($p, $m, $a, 1);  // launch tree exploration
    if ($verbose) {
        echo "</pre><center>$nl";
    }

    $ICknown[$a] = 1;
    $p           = $fathers[$a];
    $m           = $mothers[$a];
    foreach ($fathers as $i => $pere) {  /* siblings share the same COI value */
        //        if ($i <> $a && $pere == $p && $mothers[$i] == $m) {
        if ($i != $a && $pere == $p && $mothers[$i] == $m && isset($COIs[$a])) {
            $COIs[$i]    = $COIs[$a];
            $ICknown[$i] = 1;
        }
    }

    // echo "<!-- COI($a) = $COIs[$a] $IDs[$a] ($fathers[$a] x $mothers[$a])-->$nl" ;
    return 0;
}

/**
 * @param $nb_gen
 * @param $nloop
 *
 * @return int
 */
function boucle($nb_gen, $nloop)
{
    global $fathers, $mothers, $nbanims, $listing, $nl, $IDs;
    $nbtot   = 0;
    $listing = '';
    if ($nloop < ($nb_gen + 20)) {
        $nloop = $nb_gen + 20;
    }
    $list = array(0 => 1);
    //print_r($list);
    /* initialize list with Anim0 (rank = 1) */
    for ($j = 1; $j < $nloop; ++$j) {
        $new = 0;
        foreach ($list as $i => $rank) {
            if ($s = $fathers[$i]) {
                if (!$list[$s]) {
                    $new = 1;
                    if ($j < $nb_gen) {
                        ++$nbtot;
                    }
                }
                $list[$s] = $rank + 1;
                if ($j < $nb_gen) {
                    ++$nbtot;
                }
                if ($j > $nloop - 10) {
                    $listing .= "Loop $j: Animal #$s " . $IDs[$s] . $nl;
                }
            }
            if ($d = $mothers[$i]) {
                if (!$list[$d]) {
                    $new = 1;
                    if ($j < $nb_gen) {
                        ++$nbtot;
                    }
                }
                $list[$d] = $rank + 1;
                if ($j < $nb_gen) {
                    ++$nbtot;
                }
                if ($j > $nloop - 10) {
                    $listing .= "Loop $j: Animal #$d " . $IDs[$d] . $nl;
                }
            }
        }
        if (!$new) {
            break;
        }
    }
    if ($new) {
        $nbtot = 0;
    }  /* Endless loop detected (see listing) */

    return $nbtot;
}

if (!function_exists('html_accents')) {
    /**
     * @param $string
     * @return mixed
     */
    function html_accents($string)
    {
        return $string;
    }
}

/**
 * @param $ID
 * @return mixed
 */
function set_name($ID)
{
    global $sql2, $sql2bis;
    $name = ' ';
    $ID   = (int)$ID;
    $ani  = array();
    if ($ID) {
        $sqlquery    = 'SELECT ID, NAAM, roft from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID = '$ID'";
        $queryresult = $GLOBALS['xoopsDB']->queryF($sqlquery);
        $ani         = $GLOBALS['xoopsDB']->fetchBoth($queryresult);
        $name        = $ani[1];
        if ($sql2bis) {  // true for E.R.o'S. only 
            $name = html_accents($name);
            //$affx = $ani[5] ;  // affix-ID
            if ($affx) {
                $affix  = fetch_record("$sql2bis '$affx'");
                $type   = $affix[1];
                $affixe = html_accents($affix[0]);
                if ($type[0] === 'P') {
                    $name = '<i>' . $affixe . '</i>&nbsp;' . $name;
                }
                if ($type[0] === 'S') {
                    $name = $name . '&nbsp;<i>' . $affixe . '</i>';
                }
            }
            $ani[1] = $name;
        }
    }

    return $ani;
}

/**
 * @param $ems
 *
 * @return string
 */
function Ems_($ems)
{
    if (function_exists('Ems')) {
        return Ems($ems);
    }
    if (!$ems) {
        return '&nbsp;';
    }
    $e   = str_replace(' ', '+', $ems);
    $res = '<a href="#" style="text-decoration:none;" onClick="' . "window.open('http://www.somali.asso.fr/eros/decode_ems.php?$e'," . "'', 'resizable=no,width=570,height=370')" . '"' . "><b>$ems</b></a>";

    return $res;
}

/**
 * @param $ID
 *
 * @return string
 */
function one_animal($ID)
{
    global $xoopsDB;
    global $sex, $val, $sosa, $detail, $sql3;
    $content = '';
    $sosa    = 12;
    // echo '<div style="position:relative;float:right;width=2.0em;color=white;">' . $sosa . '</div>' ;
    $animal = set_name($ID);

    if (is_array($animal)) {
        //list($ID, $name, $sex, $hd, $ems) = $animal;
        list($ID, $name, $sex) = $animal;
    }
    $sqlquery    = 'select SQL_CACHE count(ID) from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where vader = '$ID' or moeder = '$ID'";
    $queryresult = $GLOBALS['xoopsDB']->queryF($sqlquery);
    $nb          = $GLOBALS['xoopsDB']->fetchBoth($queryresult);
    $nb_children = $nb[0];
    if ($nb_children == 0) {
        $nb_children = _PED_COI_NO;
    }
    //    $dogid = $animal[0];
    $content .= '<tr><td><a href="dog.php?id=' . $ID . '">' . stripslashes($name) . '</a>';
    // if ($nb_enf == 0) echo ' &oslash;' ;
    if ($val) {
        $content .= $val;
    }
    if ($sex == 1) {
        $geslacht = '<img src="images/female.gif">';
    }
    if ($sex == 0) {
        $geslacht = '<img src="images/male.gif">';
    }
    $content .= '</td><td>' . $geslacht . '</td><td>' . $nb_children . _PED_COI_OFF . '</td></tr>';

    return $content;
}

/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  MAIN  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

//mb $larg = strlen($QUERY_STRING);
$nl = "\n";  // the newline character

//mb $rem = $REMOTE_ADDR;
//edit by jc
//$link = @mysqli_pconnect ($host, $database, $password)
//   or   die ("<html><body>Connection to database failed.</body></html>") ;

//$a = '';
$a = null;
$s = Request::getInt('s', 0, 'GET'); //_GET['s'];
$d = Request::getInt('d', 0, 'GET'); //$_GET['d'];
//$detail = Request::getString('detail','' , 'GET'); //$_GET['detail'];
$detail = Request::hasVar('detail', 'GET') ? Request::getString('detail', '', 'GET') : null; //$_GET['detail'];

if (isset($si)) {
    $s = findid($si);
}
if (isset($da)) {
    $d = findid($da);
}
//test for variables
//echo "si=".$si." da=".$da." s=".$s." d=".$d;
$utils = $GLOBALS['xoopsDB']->queryF("select user(), date_format(now(),'%d-%b-%Y')");
list($who, $jourj) = $GLOBALS['xoopsDB']->fetchBoth($utils);

if (isset($IC)) {
    $detail = -1;
    $a      = $IC;
}

//if (!isset($detail)) {
if (null === $detail) {
    $detail = 0;
}

if (!isset($a)) {
    if (isset($s) && !isset($d)) {
        $a = $s;
        $s = '';
    }
    if (isset($d) && !isset($s)) {
        $a = $d;
        $d = '';
    }
}
/*
if (!isset($a) && !isset($s) && !isset($d)) {
    $a = 224586;
}  // default is Graf Eberhard von Hohen-Esp (test pedigree, F=0.390625)
*/

if (isset($a)) {
    $sqlquery    = 'select ID, vader, moeder, roft from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID  = '$a'";
    $queryresult = $GLOBALS['xoopsDB']->queryF($sqlquery);
    $rowhond     = $GLOBALS['xoopsDB']->fetchBoth($queryresult);
    $a           = $rowhond['ID'];
    $s           = $rowhond['vader'];
    $d           = $rowhond['moeder'];
}
$a += 0;
$s += 0;
$d += 0;            // [IDs are numbers]

$xoopsTpl->assign('ptitle', _PED_COI_CKRI);
$xoopsTpl->assign('pcontent', strtr(_PED_COI_CKRI_CTS, array('[animalType]' => $moduleConfig['animalType'])));
?>


<input type="button" class="btn btn-primary" value="Go to Back" name="gotoback" id="gotoback"/>

<?php
if (!$s && !$d) {
    $error = _PED_COI_SPANF1 . $a . _PED_COI_SPANF2;
    $xoopsTpl->assign('COIerror', $error);
}

$maxn_ = 1000;
$maxr_ = 9;

$maxn     = $maxn_;
$maxr     = $maxr_;
$cinnamon = 0;
$chocolat = 0;
$dilution = 0;
$sexlred  = 0;

$nivomin = -$maxr; /* Maximal depth of recursion (-10) */
$codec   = 0;
$gens    = 4;         /* 4 gens. for both pedigrees of couple */
$litter  = 0;
$codec1  = $s;  //father
$codec2  = $d; //mother

$val = '';

if (!$s && $d) {
    $codec1 = $d;
    $codec2 = 0;
}
if ($codec1 == $codec2) {
    $codec2 = 0;
}

$sqlquery    = 'select ID, vader, moeder, roft from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID  = '$codec1'";
$queryresult = $GLOBALS['xoopsDB']->queryF($sqlquery);
$rowhond     = $GLOBALS['xoopsDB']->fetchBoth($queryresult);
$a1          = $rowhond['ID'];
$s1          = $rowhond['vader'];
$d1          = $rowhond['moeder'];
$sex1        = $rowhond['roft'];

$sqlquery    = 'select ID, vader, moeder, roft from ' . $GLOBALS['xoopsDB']->prefix('stamboom') . " where ID  = '$codec2'";
$queryresult = $GLOBALS['xoopsDB']->queryF($sqlquery);
$rowhond     = $GLOBALS['xoopsDB']->fetchBoth($queryresult);
$a2          = $rowhond['ID'];
$s2          = $rowhond['vader'];
$d2          = $rowhond['moeder'];
$sex2        = $rowhond['roft'];

/*
if ($sex1 == '0' && $sex2 == '1') {
    $a3 = $a1; //a3 becomes ID of the original father
    $a1 = $a2; //a1 becomes ID of the original mother
    $a2 = $a3; //a2 becomes ID of the original father, so we've switched that
}   
*/
/* permute dam and sire */
$codec1 = $a1; //this becomes now ID of the original mother
$codec2 = $a2;  //this becomes now ID of the original father
if (!isset($s1) || !isset($d1) || !isset($s2) || !isset($d2)) {
    //if (!$s1 || !$d1 || !$s2 || !$d2) {
    $xoopsTpl->assign('COIerror', _PED_COI_SGPU);
}

$title   = strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father'])) . ' (' . stripslashes(showparent($codec2)) . ')' . _PED_COI_AND . strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother'])) . ' (' . stripslashes(showparent($codec1)) . ')';
$content = stripslashes(one_animal($codec2));
$content .= stripslashes(one_animal($codec1));
$val     = '';
$xoopsTpl->assign('SADtitle', $title);
$xoopsTpl->assign('SADcontent', $content);
$xoopsTpl->assign('SADexplain', strtr(_PED_COI_SDEX, array('[animalType]' => $moduleConfig['animalType'], '[animalTypes]' => $moduleConfig['animalTypes'], '[children]' => $moduleConfig['children'])));

$de_cujus = 0;
$sire_ID  = Request::getInt('s', 0, 'GET');//$_GET['s'];
$dam_ID   = Request::getInt('d', 0, 'GET');//$_GET['d'];
$rec      = 'SELECT ID FROM ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' WHERE vader = ' . $sire_ID . ' AND moeder = ' . $dam_ID . ' ORDER BY NAAM';

//echo '$sire_ID= ' . $sire_ID  . '<br>';
//echo '$dam_ID= ' . $dam_ID  . '<br>';
//echo '$rec= ' . $rec  . '<br>';
$result  = $GLOBALS['xoopsDB']->query($rec);
$content = '';
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $content .= one_animal($row['ID']);
}

$xoopsTpl->assign('COMtitle', strtr(_PED_COI_COMTIT, array('[father]' => $moduleConfig['father'], '[mother]' => $moduleConfig['mother'])));
$xoopsTpl->assign('COMexplain', strtr(_PED_COI_COMEX, array('[animalType]' => $moduleConfig['animalType'], '[children]' => $moduleConfig['children'])));
$xoopsTpl->assign('COMcontent', $content);

if (!isset($nb_gen)) {
    $nb_gen = 7;
    if ($detail) {
        //if (null !== $detail) {
        $nb_gen = 9;
    }
} elseif ($nb_gen < $pedigree) {
    $nb_gen = $pedigree;
}

$IDs = array($de_cujus + 0, $codec1 + 0, $codec2 + 0);  /* Structuring animal IDs into memory */

$nbanims = GENEALOGY();   // ************************************************************* //

for ($i = 0; $i <= $nbanims; ++$i) {
    $empty[$i] = 0;
}

foreach ($fathers as $i => $a) {
    if ($a) {
        $fathers[$i] = $inds[$a];
    }
}
/* Replace parents codes */
foreach ($mothers as $i => $a) {
    if ($a) {
        $mothers[$i] = $inds[$a];
    }
}  /*   by  their  indices  */

dist_m($mothers[0]);  // set "$mater" array (list of all maternal ascendants), for Anim #0

/* Calculating CONSANGUINITY by dual (paternal & maternal) path method */
$f       = $empty;
$ICknown = $empty;
$deltaf  = $empty;
$marked  = $empty;
$SSDcor  = $SSDsire = $SSDdam = 0;

//echo ' $COIs[0]= ' . $COIs[0] . ' <br>';

/******************  LAUNCHING ALL RECURSIONS  ********************/
/*                                                                */
CONSANG(-1);      /* [-1 is standing for de_cujus]
/*                                                                */
/******************************************************************/

//echo ' $COIs[0]= ' . $COIs[0] . ' <br>';

//global $COIs;
$nf = ceil(100 * $COIs[0]);
//echo ' $nf= ' . $nf . ' <br>';
$nf1 = ceil(100 * (isset($COIs[0]) ? $COIs[0] : 0));
//echo ' $nf1= ' . $nf1 . ' <br>';
if ($nf >= 55) {
    $w = _PED_COI_HUGE;
} elseif ($nf >= 35) {
    $w = _PED_COI_VHIG;
} elseif ($nf >= 20) {
    $w = _PED_COI_HIGH;
} elseif ($nf >= 10) {
    $w = _PED_COI_MEDI;
} elseif ($nf >= 05) {
    $w = _PED_COI_LOW;
} elseif ($nf >= 02) {
    $w = _PED_COI_VLOW;
} elseif ($nf >= 01) {
    $w = _PED_COI_VVLO;
} else {
    $w = _PED_COI_TLTB;
}
$w = _PED_COI_TVI . ' ' . $w;

$nb_all = 0;
count_all(0, 0);  // count all ascendants in flat tree

$nbmax  = (2 << $nb_gen) - 2;
$asctc  = _PED_COI_ASTC . $nb_gen . _PED_COI_ASTCGEN . $nbmax . ')';
$ascuni = _PED_COI_ASDKA . $nb_gen . _PED_COI_ASGEN;
$xoopsTpl->assign('ASCtitle', _PED_COI_ACTIT);
$xoopsTpl->assign('ASCtc', $asctc);
$xoopsTpl->assign('ASCuni', $ascuni);
$xoopsTpl->assign('ASCall', $nb_all);
$xoopsTpl->assign('ASCani', $nbani);
$xoopsTpl->assign('ASCexplain', _PED_COI_ACEX);
//if (isset($COIs[0])) {
$f0 = substr($COIs[0], 0, 8);
//}
if (!isset($f0)) {
    // $f0 = 'n.a.';
    $f0 = 0;
}
//echo ' $f0= ' . $f0 . ' <br>';
$f1 = 100 * $f0;
//$f1 = 1*$f0;
//echo ' $f1= ' . $f1 . ' <br>';

$xoopsTpl->assign('COItitle', strtr(_PED_COI_COITIT, array('[father]' => $moduleConfig['father'], '[mother]' => $moduleConfig['mother'])));
$xoopsTpl->assign('COIperc', $w);
$xoopsTpl->assign('COIval', $f1);
$xoopsTpl->assign('COIexplain', strtr(_PED_COI_COIEX, array('[animalType]' => $moduleConfig['animalType'], '[animalTypes]' => $moduleConfig['animalTypes'], '[children]' => $moduleConfig['children'])));
$xoopsTpl->assign('COIcoi', _PED_COI_COI);

$dogs  = array();
$dogid = Request::getInt('dogid', 0, 'GET');
$query = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('stamboom') . ' SET coi=' . $f1 . ' WHERE ID = ' . $dogid;
$GLOBALS['xoopsDB']->queryf($query);
arsort($deltaf);
$j = 1;
foreach ($deltaf as $i => $v) {
    if ($j > 12) {
        break;
    }
    $j++;
    if (isset($IDs[$i])) {
    $code   = $IDs[$i];
    $v      = substr($v, 0, 7);
    $animal = set_name($IDs[$i]);
    if (isset($animal[1])) {
        $name = $animal[1];
    } else {
        //if (!$name) {
        $name = $i . ' [' . $IDs[$i] . ']';
    }
    }
    if ($v > 0.0001 && $v < 1.0) {
        $dogs[] = array('id' => $code, 'name' => stripslashes($name), 'coi' => 100 * $v);
    }
}

$xoopsTpl->assign('TCAtitle', _PED_COI_TCATIT);
$xoopsTpl->assign('TCApib', _PED_COI_TCApib);
$xoopsTpl->assign('dogs', $dogs);
$xoopsTpl->assign('TCAexplain', strtr(_PED_COI_TCAEX, array(
    '[animalType]'  => $moduleConfig['animalType'],
    '[animalTypes]' => $moduleConfig['animalTypes'],
    '[children]'    => $moduleConfig['children'],
    '[mother]'      => $moduleConfig['mother'],
    '[father]'      => $moduleConfig['father']
)));
$mia = array();
$COR = 0;
//if ($detail) {
if (isset($detail)) {
    if ($verbose) {
        $verbose = 0;
    }
    if (count($COIs) > 1) {
        $ICs = $COIs;
        arsort($ICs);
        $j = 1;
        foreach ($ICs as $i => $ic) {
            if ($j > 12) {
                break;
            }
            ++$j;
            $ID  = $IDs[$i];
            $ani = set_name($ID);
            if (isset($ani[1])) {
                $name = $ani[1];
            }
            $ic = substr($ic, 0, 6);
            if ($ic > 0.125 && $i) {
                $mia[] = array('id' => $ID, 'name' => stripslashes($name), 'coi' => 100 * $ic);
            }
        }
    }
    $xoopsTpl->assign('MIAtitle', _PED_COI_MIATIT);
    $xoopsTpl->assign('mia', $mia);
    $xoopsTpl->assign('MIAexplain', strtr(_PED_COI_MIAEX, array('[animalType]' => $moduleConfig['animalType'])));

    if (!$ICknown[1]) {
        $marked = $empty;
        CONSANG(1);
    }    // Sire
    if (!$ICknown[2]) {
        $marked = $empty;
        CONSANG(2);
    }    // Dam

    //    echo '------------- dam <br>';
    //echo '$COIs ' . $COIs . '<br>';
    //echo '$COIs[0] ' . $COIs[0] . '<br>';
    //echo '$COIs[1] ' . $COIs[1] . '<br>';
    //echo '$COIs[2] ' . $COIs[2] . '<br>';

    if (isset($COIs[0]) && isset($COIs[1]) && isset($COIs[2])) {

        $COR = 2.0 * $COIs[0] / sqrt((1. + $COIs[1]) * (1. + $COIs[2]));
    }
    //echo '$COR1: '.$COR."<br>";

    $COR = substr($COR, 0, 8);

    //echo '$COR2: '.$COR."<br>";

    if (!$COR) {
        //        $COR = 'n.a.';
        $COR = 0;
    }
    //    if (isset($COIs[0]) && isset($COIs[1]) && isset($COIs[2])) {
    $f1 = isset($COIs[1]) ? substr($COIs[1], 0, 8): 0;
    $f2 = substr($COIs[2], 0, 8);
    //}
    //echo '$f1: '.$f1."<br>";
    //echo '$f2: '.$f2."<br>";

    if (!isset($f1)) {
        // $f1 = 'n.a.';
        $f1 = 0;
    }
    if (!isset($f2)) {
        // $f2 = 'n.a.';
        $f2 = 0;
    }
    $SSDcor  = (100 * $COR);
    $SSDsire = (100 * $f2);
    $SSDdam  = (100 * $f1);
}

//echo "SSDsire: ".$SSDsire."<br>";
//echo "SSDdam: ".$SSDdam."<br>";
$xoopsTpl->assign('SSDtitle', strtr(_PED_COI_SSDTIT, array('[father]' => $moduleConfig['father'], '[mother]' => $moduleConfig['mother'])));
$xoopsTpl->assign('SSDcortit', _PED_COI_SSDcor);
$xoopsTpl->assign('SSDbsd', strtr(_PED_COI_SDDbsd, array('[father]' => $moduleConfig['father'], '[mother]' => $moduleConfig['mother'])));
$xoopsTpl->assign('SSDcor', $SSDcor);
$xoopsTpl->assign('SSDS', _PED_COI_COI . _PED_FROM . strtr(_PED_FLD_FATH, array('[father]' => $moduleConfig['father'])));
$xoopsTpl->assign('SSDsire', $SSDsire);
$xoopsTpl->assign('SSDM', _PED_COI_COI . _PED_FROM . strtr(_PED_FLD_MOTH, array('[mother]' => $moduleConfig['mother'])));
$xoopsTpl->assign('SSDdam', $SSDdam);
//print_r($COIs);
$xoopsTpl->assign('SSDexplain', strtr(_PED_COI_SSDEX, array('[father]' => $moduleConfig['father'], '[mother]' => $moduleConfig['mother'], '[animalType]' => $moduleConfig['animalTypes'])));
$xoopsTpl->assign('TNXtitle', _PED_COI_TNXTIT);
$xoopsTpl->assign('TNXcontent', _PED_COI_TNXCON);
$xoopsTpl->assign('Name', _PED_FLD_NAME);
$xoopsTpl->assign('Gender', _PED_FLD_GEND);
$xoopsTpl->assign('Children', strtr(_PED_FLD_PUPS, array('[children]' => $moduleConfig['children'])));

//add data to smarty template
$xoopsTpl->assign('explain', _PED_EXPLAIN);

//comments and footer
include XOOPS_ROOT_PATH . '/footer.php';
//?>
<!--<input type="button" value="Go to Back" name="gotoback1" id="gotoback1"/>-->
<?php
?>
