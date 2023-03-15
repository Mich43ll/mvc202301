<main>
    <table>
        <tr>
            <th>Codigo</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Monto</th>
            <th>
                <a href="index.php?page=Mnt_Journal&mode=INS">Nuevo</a>
            </th>
        </tr>
        {{foreach journals}}
        <tr>
            <td>{{journal_id}}</td>
            <td><a href="index.php?page=Mnt_Journal&mode=UPD&journal_id={{journal_id}}">{{journal_date}}</a> </td>
            <td>{{journal_type}}</td>
            <td>{{journal_description}}</td>
            <td>{{journal_amount}}</td>
            <td><a href="index.php?page=Mnt_Journal&mode=UPD&journal_id={{journal_id}}">Editar</a>&nbsp;
            <a href="index.php?page=Mnt_Journal&mode=DEL&journal_id={{journal_id}}">Eliminar</a></td>
        </tr>
        {{endfor journals}}
    </table>

</main>