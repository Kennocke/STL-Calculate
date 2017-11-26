<?php
  error_reporting( E_ERROR );
  const HEADER_BYTES = 80;
  const FACETS_COUNT_BYTES = 4;
  // Мы будем читать сразу по 3 значения для вектора и вертекса.
  // В теории можно прочитать сразу весь фасет, но тогда "pattern" для чения длинноват будет.
  const VECTOR_SIZE_BYTES = 12; //3*4
  const VERTEX_SIZE_BYTE = 12; // 3*4
  const VERTICES_COUNT = 3;

  // Патерн для получения массива с элементами x, y, z. где тип переменной g  - float (machine dependent size, little endian byte order)      
  const FACET_END_BYTES = 2;
  const TRIPLET_EXTRACT_PATTERN = 'gx/gy/gz';

  $filename = "C:/xampp/tmp/" .basename($_FILES['uploadfile']['tmp_name']);
  $sf = fopen($filename, 'rb');

  $header = fread($sf, HEADER_BYTES);

  $facetsCountBytes = fread($sf, FACETS_COUNT_BYTES);
  // Current  очень важно так как unpack() возвращает массив
  $facetsCount = current(unpack("I", $facetsCountBytes));

  $sum = 0.0;
  $plot = 0.0;

  for ($i=0; $i<$facetsCount; $i++) {

      $facet =[];
      // Читаем и распоковываем вектор
      // Когда читал по одному элементу а не три сразу, распоковка выдавала ерунду.
      $vectorBytes = fread($sf, VECTOR_SIZE_BYTES);
      $facet['vector'] = unpack(TRIPLET_EXTRACT_PATTERN, $vectorBytes);
	  

      // Читаем и распоковываем вертексы 
      for ($j=1; $j<=VERTICES_COUNT; $j++) {
          $vertexBytes = fread($sf, VERTEX_SIZE_BYTE);
          $facet['vertex'.$j] = unpack(TRIPLET_EXTRACT_PATTERN, $vertexBytes);
      }
	  
      $endBytes = fread($sf, FACET_END_BYTES);
      $facet['end'] = current(unpack('S', $endBytes));

	  $sum += ((-1) * $facet[vertex3][x] * $facet[vertex2][y] * $facet[vertex1][z] + $facet[vertex2][x] * $facet[vertex3][y] * $facet[vertex1][z] + $facet[vertex3][x] * $facet[vertex1][y] * $facet[vertex2][z] - $facet[vertex1][x] * $facet[vertex3][y] * $facet[vertex2][z] - $facet[vertex2][x] * $facet[vertex1][y] * $facet[vertex3][z] + $facet[vertex1][x] * $facet[vertex2][y] * $facet[vertex3][z])/6;
  }
  $sum = $sum / 1000;
  print_r ("Объём: " .$sum ." см.куб<br>");
  
  $i = $_POST[s];
  switch ($i) {
    case "ABS":
		$plot = $sum * 1.05;
        echo "Вес: " .$plot ." грм";
        break;
    case "PLA":
        $plot = $sum * 1.25;
        echo "Вес: " .$plot ." грм";
        break;
    case "Nylon":
        $plot = $sum * 1.134;
        echo "Вес: " .$plot ." грм";
        break;
}