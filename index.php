<!DOCTYPE html>
<html>
    <head>
        <title>Google Search API</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <meta name="description" content="PHP CURL google search API">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="api.php" method="POST" id="searchForm">
                            <div class="form-group">
                                <input type="search" name="query" placeholder="Enter your keyword here" class="form-control" id="searchKey">
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-primary btn-lg" onclick="searchKeyword();">Show Results</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12 my-5 table-responsive">
                        <table class="table table-bordered table-condensed" style="width: 100%" cellpadding="0" cellspacing="0">
                            <thead>
                                <th>Sl No.</th>
                                <th>Title</th>
                                <th>Description</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript">
            function searchKeyword(){
                $(".table").find("tbody").empty();
                $.ajax({
                    type:"POST",
                    url:"api.php",
                    data:{query:$("#searchKey").val()},
                    dataType:"json",
                    success:function(data){
                        if(data.success == 1)
                        {
                            let i = 1;
                            $.each(data.details,function(k,v){
                               $(".table").find("tbody").append(`
                                <tr>
                                    <td>${i}</td>
                                    <td>${v.title}</td>
                                    <td>${v.snippet}</td>
                                </tr>
                                `);
                               i++;
                            });
                            var link = document.createElement('a');
                            link.href = 'output.csv';
                            link.download = 'results.csv';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                        else{
                            alert(data.error);
                        }
                    }
                })
            }
        </script>
    </body>
</html>