$(document).ready(function () {
    $('#searchButton').on('click', function (){
        let id = $('#searchInput').val();

        if (!id) {
            return;
        }

        $.ajax({
            url: `/user/search/${id}`,
            method: "GET",
            success: function (data) {
                if (data.status === 'error') {
                    alert(data.message)

                    return;
                }

                let user = data.data;
                let tableBody = $("table tbody");
                tableBody.empty();

                let row = `<tr>
                    <th scope="row">1</th>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.gender === 'male' ? 'Mężczyzna' : 'Kobieta'}</td>
                    <td>${user.status === 'active' ? 'Aktywny' : 'Nieaktywny'}</td>
                    <td><a href="/user/${user.id}/posts" class="btn btn-warning">Wpisy</a></td>
                </tr>`;

                tableBody.append(row);
            },
        });
    });
});
