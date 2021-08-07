
<?

$homepage = file_get_contents(("https://wamm.chat/api2/msg_to/f0sZ7BuL/?phone=79231135235&text=lala"));


$checkerror_string = $homepage;
$checkerror_string = str_replace('{','',$checkerror_string);
$checkerror_string = str_replace('}','',$checkerror_string);

$arr = explode(',',$checkerror_string);

$err_array = explode(':',$arr[0]);
echo $err_array[1];
?>