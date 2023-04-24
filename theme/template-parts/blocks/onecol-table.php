<?php
$table = get_field( 'table' );
$tableHeader = get_field('enable_table_heading');

if($tableHeader) { 
    $header = get_field('table_header');
    $description = get_field('table_description');
    ?>
    <div class="one-col-table-header-container">
        <h4 class="one-col-table-header"><?= $header; ?></h4>

        <p class="one-col-table-description"><?= $description; ?></p>
    </div>
<?php }

if ( ! empty ( $table ) ) { ?>

    <div class="one-col-tsble-container">

        <?php echo '<table class="emc-table" border="0">';

            if ( ! empty( $table['caption'] ) ) {

                echo '<caption class="emc-table-caption">' . $table['caption'] . '</caption>';
            }

            if ( ! empty( $table['header'] ) ) {

                echo '<thead class="emc-table-header">';

                    echo '<tr class="emc-table-header-row">';

                        foreach ( $table['header'] as $th ) {

                            echo '<th class="emc-table-header-row-heading">';
                                echo $th['c'];
                            echo '</th>';
                        }

                    echo '</tr>';

                echo '</thead>';
            }

            echo '<tbody class="emc-table-body">';

                foreach ( $table['body'] as $tr ) {

                    echo '<tr class="emc-table-body-row">';

                        foreach ( $tr as $td ) {

                            echo '<td class="emc-table-body-data">';
                                echo $td['c'];
                            echo '</td>';
                        }

                    echo '</tr>';
                }

            echo '</tbody>';

        echo '</table>'; ?>
    </div>
    <?php
}