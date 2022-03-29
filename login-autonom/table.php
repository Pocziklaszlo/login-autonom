<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Dolgozók adatai</title>
    <script>
        var pageVar = 1;
        function loadData(page){
            $.post('http://localhost/login-autonom/index.php/loadData',{page:pageVar},function(data){
                let dataObjects = JSON.parse(data);

                if(pageVar != dataObjects.pageData.nextPage){
                    pageVar = dataObjects.pageData.nextPage;
                }

                $('#tableContainer').html('');

                var tableTemplate = '<table id="dataTable">' + 
                        '<th>' +
                            '<tr>Employee no.</tr>' +
                            '<tr>Birth date</tr>' +
                            '<tr>First name</tr>' + 
                            '<tr>Last name</tr>' +
                            '<tr>Gender</tr>' +
                            '<tr>Hire date</tr>' +
                            '<tr>Salary</tr>' +
                            '<tr>Title</tr>' +
                            '<tr>Dept. name</tr>' +
                        '</th>' +
                    '</table>' + 
                    '<a id="prev_a" href="">[Prev]</a>' +
                    '<a id="next_a" href="">[Next]</a>';

                    $('#tableContainer').append(tableTemplate);

                /*
                * Insert data
                */
                $.each(dataObjects.data,function(index,item){
                    var template = 
                    '<tr>' + 
                        '<td>' + item.emp_no + '</td>' + 
                        '<td>' + item.birth_date +  '</td>' +
                        '<td>' + item.first_name + '</td>' +
                        '<td>' + item.last_name + '</td>' +
                        '<td>' + item.gender + '</td>' +
                        '<td>' + item.hire_date + '</td>' +
                        '<td>' + item.salary +'</td>' +
                        '<td>' + item.title + '</td>' +
                        '<td>' + item.osztaly + '</td>' +
                    '</tr>';

                    $('#dataTable').append(template);
                    $('#prev_a').attr('href',(pageVar - 2));
                    $('#next_a').attr('href',pageVar);
                });
            });
        }

        $(document).ready(function(e){

            $('#prev_a').click(function(e){
                e.preventDefault();
                let page = parseInt($(this).attr('href'));
                loadData(page);
            });

            $('#next_a').click(function(e){
                e.preventDefault();
                let page = parseInt($(this).attr('href'));
                loadData(page);
            });

            /**
             * Load data
             */

             loadData(1);
        });
    </script>
</head>
<body>

    <div id="tableContainer">
        <table id="dataTable">
            <th>
                <tr>Employee no.</tr>
                <tr>Birth date</tr>
                <tr>First name</tr>
                <tr>Last name</tr>
                <tr>Gender</tr>
                <tr>Hire date</tr>
                <tr>Salary</tr>
                <tr>Title</tr>
                <tr>Dept. name</tr>
            </th>
        </table>
        <a id="prev_a" href="">[Prev]</a>
        <a id="next_a" href="">[Next]</a>
    </div>
    
</body>
</html>