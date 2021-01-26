<html>
<body>

<select>
<optgroup label="Category_1">

<option value="1">Subcategory_one</option>
<option value="1">Subcategory_eshe</option>
</optgroup>

<optgroup label="Category_eshe">

<option value="3">Subcategory_thir</option>


</optgroup>
</select>

<select name="groups[]" multiple="" size="10" >
    <option value="2">Мужчины 18-24</option>
    <option value="3">Женщины 18-24</option>
    <option value="4">Мужчины 25-34</option>
    <option value="5">Женщины 25-34</option>
</select>
 

<?php
//$array1 = array('blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4);
//$array2 = array('green' => 5, 'yellow' => 7, 'cyan' => 8);

//var_dump(array_diff_key($array1, $array2));
//var_dump($array1);
//var_dump($array2);

//$array1 = array('blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4);
$array1= array ();
$array1[0][0]=1;
$array1[0][1]=2;
$array1[1][1]=3;
foreach($array1 as $brand => $massiv)
{

echo $massiv;
 
}
 

?>



</body>
</html>