<?php

// add your server aliases here
$servers = array(
    '54.84.34.197' => 'thejeffbyrnes.com'
    // '185.14.184.xxx' => 'thejeffbyrnes.com'
);

$stats_file_path = $_SERVER['DOCUMENT_ROOT'] . '/../shared/stats.json';

// this script is triggered by this command from the terminal or cron:
// echo 'time=`uptime`&df=`df -h`" | curl -s -d @- http://domain.com/path/to/script.php

// record data
if (isset($_POST['time'], $_POST['df'])) {
    // getting the server load
    preg_match('/\d+\.\d{2}/', $_POST['time'], $load);

    // get available disk space
    preg_match('/\d+%/', $_POST['df'], $df);

    if(    !count($load)
        || !count($df)
    ) {
        return false;
    }

    $stats = array(
        'df'   => $df[0],
        'load' => $load[0],
        'ip'   => $_SERVER['REMOTE_ADDR']
    );

    save_to_stats($stats);
} else {
    output_stats_table();
}

function save_to_stats($stats)
{
    // Pull in variables
    global $stats_file_path;

    $data               = json_decode(file_get_contents($stats_file_path), true);
    $data[$stats['ip']] = $stats;

    file_put_contents($stats_file_path, json_encode($data), LOCK_EX);
}

function output_stats_table()
{
    // Pull in variables
    global $servers, $stats_file_path;

    // display data
    $data = json_decode(file_get_contents($stats_file_path), true);
    ?>

    <table id="projects">
        <?php
        foreach ($data as $server => $stats):
            ?>

            <tr>
                <td class="server-name" style="width:400px; text-transform:lowercase;"><?php echo $servers[$stats['ip']] ; ?></td>

                <td class="server-disk-space"><?php echo $stats['load']; ?></td>

                <td class="projectsBars">
                    <?php
                    for ($i = 1, $j = number_of_bars($stats['df']); $i <= $j; $i++) :
                        ?>

                        <div class="barSegment value<?php echo $i; ?>"></div>

                        <?php
                    endfor;
                    ?>

                </td>
            </tr>

            <?php
        endforeach;
        ?>
    </table>

    <?php
};

function number_of_bars($df)
{
    $value = (int)str_replace('%', '', $df) / 10;

    return round(($value > 8 ? 8 : $value) * .8);
}
