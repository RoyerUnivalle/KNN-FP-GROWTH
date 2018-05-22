# KNN-FP-GROWTH

**Integración de los algoritmos en el Sistema de Información WEB

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

**Algoritmo FP GROWTH**

<p align="center">
  <img src="/Ingenieria/Diagrama_Complejidad_Ciclomatica/FP_GROWTH.png" width="350"/>
</p>
