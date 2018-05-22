# KNN-FP-GROWTH

**Integración de los algoritmos en el Sistema de Información WEB**

1.	En primer lugar, se lleva a cabo el proceso de extracción, transformación y carga de datos en el Data Mart a partir de los datos registrados en la base de datos transaccional del sistema. Este proceso se encarga de mantener actualizados los datos del Data Mart ya que sobre éste se ejecutan los algoritmos FP-Growth y KNN.
2.	Si se consultan por clientes frecuentes se ejecuta el algoritmo FP-Growth con el fin de obtener dichos clientes a partir de la cantidad de ventas registradas a cada uno mientras cumplan con el umbral definido para ello. Por otra parte, si se busca analizar un cliente específico, el flujo del proceso descarta el paso número 2.
3.	Una vez se cuente con el cliente específico objeto de análisis, o los clientes frecuentes resultantes en el paso número 2, se ejecuta el algoritmo FP-Growth para obtener los productos más vendidos a cada uno de ellos, esto por medio de la poda al árbol de ocurrencias resultante de analizar las ventas por cada cliente.
4.	Finalmente, se ejecuta el algoritmo KNN para determinar el conjunto de productos recomendados al cliente a partir de la similitud entre la composición de estos productos y la composición de los productos obtenidos en el punto 3. La composición de cada producto está determinada por los ingredientes que contiene

La siguiente figura sintetiza el flujo de proceso.

<p align="center">
  <img src="/Ingenieria/Diagrama_Complejidad_Ciclomatica/integracion_algoritmos.png" width="350"/>
</p>

Por otra parte las siguientes ilustraciones detallan como se implementaron los algoritmos.

**Algoritmo KNN**

<p align="center">
  <img src="/Ingenieria/Diagrama_Complejidad_Ciclomatica/knn.png" width="350"/>
</p>

1. Inicia la ejecución del algoritmo KNN.
2. Válida si se generó el FP-Tree a partir del algoritmo FP-Growth.
3. Obtiene los nodos hijos del nodo raíz y valida si no están vacíos.
4. Obtiene de los nodos hijos el producto de referencia.
5. Obtiene los ingredientes de cada producto de referencia y los almacena en un arreglo de ingredientes por producto de referencia.
6. -7.Valida si el arreglo de ingredientes por producto de referencia contiene 
valores.
8. Se consulta la categoría del producto de referencia.
9. Se valida si hay productos que pertenezcan a la categoría del producto de referencia.
10. Se valida que cada producto que pertenezca a la categoría del producto de referencia tenga.
ingredientes asociados.
11. Se valida si se está accediendo a la frecuencia del producto de referencia.
12. Se obtiene la frecuencia del producto de referencia.
13. Se valida si el arreglo de productos recomendados está vacío.
14. Se emite el mensaje "No hay recomendaciones".
15. Se visualizan los productos recomendados en pantalla.
16. Se indica que no se generó la estructura FP-Tree tras la ejecución del algoritmo FP-Growth.
17. Se llena un arreglo con los ingredientes del producto de referencia.
18. Se cuentan los ingredientes del producto a comparar con el producto de referencia.
19. Se compara la cantidad de ingredientes del producto de referencia con la del producto a comparar.
20. Se valida que los arreglos de los ingredientes correspondientes al producto de referencia y al producto a comparar tengan valores.
21. Se obtienen los ingredientes del producto de referencia que no hacen parte de los ingredientes del producto a comparar.
22. Se valida que los arreglos de los ingredientes correspondientes al producto de referencia y al producto a comparar tengan valores.
23. Se obtienen los ingredientes del producto a comparar que no hacen parte de los ingredientes del producto de referencia.
24. Se calcula la distancia euclidiana a partir de la cantidad de ingredientes diferente entre los productos comparados y la cantidad total de ingredientes involucrados.
25. Se valida si el valor de similitud obtenido entre los dos productos es igual o superior al valor de similitud mínimo indicado por el usuario.
26. Se almacena el producto en el arreglo de productos recomendados a presentar al usuario.
27. Finaliza la ejecución del algoritmo KNN.

**Algoritmo FP GROWTH**

<p align="center">
  <img src="/Ingenieria/Diagrama_Complejidad_Ciclomatica/FP_GROWTH.png" width="350"/>
</p>

1. Inicia la ejecución del algoritmo FPGrowth
2. Asignación de variables, consulta de las ventas registradas y carga del arreglo Ventas.
3. Válida si se cargó el arreglo Ventas.
4. Valida si existe el arreglo de productos frecuentes.
5. Valida si existe el arreglo con los valores de la venta.
6. Valida si el arreglo con la frecuencia de los productos tiene el producto a contar registrado o no.
7. Asigna el valor '1' a la frecuencia del producto, si éste no se ha contado aún.
8. Aumenta en 1 la frecuencia acumulada del producto si éste ya ha sido contado anteriormente.
9. Ordena el arreglo de frecuencia de productos por la frecuencia de cada uno.
10. Válida si se llenó el arreglo con la frecuencia de los productos.
11. Valida los productos cuya frecuencia es igual o superior a la frecuencia mínima indicada.
12. Registra el producto en el arreglo con los productos a procesar.
13. Recorre el arreglo de los productos a procesar posición por posición.
14. Ordena los productos por frecuencia y los registra en un nuevo arreglo de productos ordenados.
15. Valida si el arreglo de productos ordenados contiene elementos.
16 -31. Construye el FP-Tree. Asigna el nodo raíz nulo y recorre el arreglo con los productos ordenados, asignándolos como nodos hoja que se desprenden del nodo raíz, asignando uno a uno, desde el más frecuente hasta el menos frecuente.
32. Finaliza la ejecución del algoritmo FPGrowth.