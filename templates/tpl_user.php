


<?php function draw_user_info($info) { ?>

    <section id="informacao">
            <header>
                <h1>User Information</h1>
            </header>

            <table>
                <tr>
                    <th>E-Mail</th>
                    <td><?=$info['mail']; ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?=$info['description']; ?></td>
                </tr>
                <tr>
                    <th>Date of Creation</th>
                    <td><?=humanTiming($info['creationDate']); ?></td>
                </tr>
            </table>

    </section>
<?php } ?>