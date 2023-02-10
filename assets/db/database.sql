  CREATE DATABASE IF NOT EXISTS `helpsystem` /*!40100 DEFAULT CHARACTER SET utf8 */;
  USE `helpsystem`;

  CREATE TABLE users (
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
      username VARCHAR(50) NOT NULL,
      email VARCHAR( 100 ) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  CREATE TABLE artigos (
    `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_postador` varchar(30) NOT NULL,
    `user_postador` varchar(30) NOT NULL,
    `titulo` varchar(200) NOT NULL,
    `data` varchar(30) NOT NULL,
    `categoria` varchar(30) NOT NULL,
    `artigo` text NOT NULL,
    `status` int(10) NOT NULL,
    `pequenadesc` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE categorias (
    `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `nome` varchar(50) NOT NULL,
    `icone` varchar(50) NOT NULL,
    `numposts` varchar(200) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
  (1, 'admin', 'admin@helpsystem.net', '$2y$10$Gj5nchruYGt0.rzU.dSJo.rF7V4YvUObBhO8DvcPTHfBr1agrweOy', '2020-03-17 19:20:28');

  INSERT INTO `categorias` VALUES (1,'Categoria Teste','fa-regular fa-heart','1'),(2,'Categoria Dois','fa-solid fa-cloud','0');

  INSERT INTO `artigos` VALUES (1,'1','admin','Artigo Teste','09/02/2023','1','Exemplo de Texto para o Artigo.',1,'Pequena Descricao');
