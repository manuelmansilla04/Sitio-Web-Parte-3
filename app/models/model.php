<?php
require_once 'config.php';

class Model {
    protected $db;

    function __construct() {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8", MYSQL_USER, MYSQL_PASS
        );
        $this->deploy();
    }

    private function deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
          $password = '$2a$12$sueSEU0qRVxmHEMjz7eMae4pkFdf20gdVUeaH8Yd1BdC0kBMNvLtG';
          $sql = <<<END
            
CREATE TABLE `categorias` (
  `id_categoria` int(255) NOT NULL,
  `nombre` varchar(1000) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `img`) VALUES
(1, 'Difusores de aromas', 'Dispersa fragancias en el aire para crear un ambiente agradable y relajante', 'https://casaefesta.com/wp-content/uploads/2023/07/como-usar-difusor-de-aromas.jpg'),
(2, 'Perfumes Textiles', 'Se usa para perfumar telas y ambientes', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/2020/11/SAPHIRUS-ROPA.png'),
(3, 'Jabones Liquidos', 'Agente limpiador en formato fluido ofrecido a través de un dispensador', 'https://cdn0.ecologiaverde.com/es/posts/2/2/7/como_hacer_jabon_liquido_casero_2722_orig.jpg');
(4, 'Aux cat 0', 'aaa aaa aaa', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/1990/jpg.jpg');
(5, 'Aux cat 1', 'bbb bbb bbb', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/1991/jpg.jpg');
(6, 'Aux cat 2', 'ccc ccc ccc', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/1992/jpg.jpg');
(7, 'Aux cat 3', 'ddd ddd ddd', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/1993/jpg.jpg');
(8, 'Aux cat 4', 'eee eee eee', 'https://elshoppingdelalimpieza.com.ar/wp-content/uploads/1994/jpg.jpg');

CREATE TABLE `productos` (
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `id_categoria` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `fecha_alta`, `id_categoria`) VALUES
(1, 'Difusor Aromatico Wood', '//imaginemos desc genérica', 34610.00, 100, '2015-09-01', 1),
(2, 'Difusor Aromatico Milk', '...', 21770.00, 100, '2015-09-02', 1),
(3, 'Difusor Aromatico', '...', 28490.00, 100, '2016-09-01', 1),
(4, 'Difusor Aromatico Coffee Cream', '...', 26390.00, 100, '2015-09-03', 1),
(5, 'Difusor Aromatico Pepper Citrus', '...', 26390.00, 100, '2016-09-01', 1),
(6, 'Difusor Aromatico Sustentable', '...', 19090.00, 100, '2015-09-02', 1),
(7, 'Difusor Aromatico This Is Love', '...', 28490.00, 100, '2016-09-08', 1),
(8, 'Difusor Aromatico This Is Fresh', '...', 28490.00, 100, '2015-09-02', 1),
(9, 'Difusor Aromatico Fresh Vetiver', '...', 33.65, 100, '2015-09-01', 1),
(10, 'Aromatizador de Ambiente This Is Love', '...', 17550.00, 100, '2016-09-08', 2),
(11, 'Aromatizador de Ambiente This Is Fresh', '...', 17550.00, 100, '2016-09-07', 2),
(12, 'Aromatizador de Ambiente This is Peace', '...', 17550.00, 100, '2015-09-18', 2),
(13, 'Aromatizador de Ambiente Tropical Fruits', '...', 12690.00, 100, '2015-09-17', 2),
(14, 'Aromatizador de Ambiente Coco & Lima', '...', 12690.00, 100, '2015-09-10', 2),
(15, 'Aromatizador de Ambiente Sensual Rose', '...', 12690.00, 100, '2016-09-09', 2),
(16, 'Aromatizador de Ambiente Fresh Vetiver', '...', 13670.00, 100, '2015-09-12', 2),
(17, 'Aromatizador de Ambiente Fresh Gardenia', '...', 13670.00, 100, '2015-09-09', 2),
(18, 'Aromatizador de Ambiente Sustentable', '...', 12690.00, 100, '2015-09-01', 2),
(19, 'Jabon Liquido Fresh Gardenia', '...', 11640.00, 100, '2015-09-05', 3),
(20, 'Jabon Liquido Dual Coco', '...', 10310.00, 100, '2015-09-03', 3),
(21, 'Jabon Liquido This is Peace', '...', 11530.00, 100, '2015-09-02', 3),
(22, 'Jabon Liquido This Is Love', '...', 11530.00, 100, '2015-09-25', 3),
(23, 'Jabon Liquido This Is Fresh', '...', 11530.00, 100, '2015-09-02', 3),
(24, 'Jabon Liquido Fresh Vetiver', '...', 11640.00, 100, '2015-09-11', 3),
(25, 'Jabon Liquido Dual Sustentable', '...', 8680.00, 100, '2015-09-03', 3),
(26, 'Aromatizador de Ambiente Black Wood', '...', 18550.00, 100, '2025-09-03', 5),
(27, 'Difusor Black Wood', '...', 42760.00, 100, '2025-09-04', 6),
(28, 'Jabon Liquido Black Wood', '...', 12790.00, 100, '2025-09-05', 3),
(29, 'Black Wood Refill', '...', 23.42, 100, '2025-09-06', 2),
(30, 'Aromatizador de Ambiente White', '...', 18.55, 100, '2025-09-01', 2),
(31, 'J abón', '...', 12.79, 6, '2026-05-16', 5);

CREATE TABLE `usuarios` (
  `ID` int(255) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`ID`, `user_name`, `password`) VALUES
(1, 'webadmin', '$password');

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;


END;
            $this->db->exec($sql);
        }
    }
}
