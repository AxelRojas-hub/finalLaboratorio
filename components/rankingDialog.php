<?php
function renderRankingDialog($baseurl)
{
?>
    <style>
        #registerDialog,
        #rankingDialog {
            text-align: center;
            z-index: 2;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 500px;
            background: var(--arcade-panel);
            border: 2px solid var(--arcade-primary);
            border-radius: var(--arcade-radius);
            padding: 2rem;
            box-shadow: 0 0 10px var(--arcade-secondary);
            backdrop-filter: blur(12px) saturate(30%);
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #rankingDialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        #registerDialog h2,
        #rankingDialog h2 {
            margin-bottom: 2rem;
        }

        #rankingTable {
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid var(--arcade-primary);
            border-radius: 8px;
            font-size: 0.95rem;
            color: #fff;
            margin-top: 0.5rem;
        }

        #rankingTable th {
            background: rgba(0, 0, 0, 0.12);
            color: white;
            font-size: 1.4rem;
            font-weight: bold;
            text-align: center;
            padding: 0.3rem 0.3rem;
            border-bottom: 1px solid #bbb;
        }

        #rankingTable td {
            padding: 0.3rem 0.2rem;
            font-size: 1.2rem;
            text-align: center;
        }

        .rankingCountry {
            text-transform: capitalize;
        }

        #rankingAnchor img,
        #rankingAnchor {
            transition: all 0.3s ease;
        }

        #rankingAnchor:hover {
            color: gold;
            text-decoration: underline;
        }

        #rankingAnchor:hover img {
            filter: brightness(1.2);
            transform: scale(1.1);

        }
    </style>

    <script>
        function openRankingDialog(event) {
            event.preventDefault();
            const dialog = document.getElementById('rankingDialog');
            dialog.showModal();
        }
    </script>

    <a id="rankingAnchor" onclick="openRankingDialog(event)" href="">
        <img class="icon" src="<?php echo $baseurl; ?>assets/ranking.svg" alt="">
        Ranking
    </a>
    <dialog id="rankingDialog" closedBy="any">
        <h2>Ranking de Jugadores</h2>
        <table id="rankingTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="15%">Posición</th>
                    <th width="40%">Nombre</th>
                    <th width="20%">Puntaje</th>
                    <th width="25%">País</th>
                </tr>
            </thead>
            <tbody id="rankingBody" border>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'memoria');

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $sql = "SELECT nombre_usuario, pais, puntaje FROM usuarios ORDER BY puntaje DESC LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $position = 1;
                    while ($row = $result->fetch_object()) {
                        echo "<tr>";
                        echo "<td>#{$position}</td>";
                        echo "<td>{$row->nombre_usuario}</td>";
                        echo "<td>{$row->puntaje}</td>";
                        echo "<td class='rankingCountry'>{$row->pais}</td>";
                        echo "</tr>";
                        $position++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </dialog>
<?php
}
?>