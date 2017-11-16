CREATE TABLE tipoRequisito (
  idTipoRequisito INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nomeTipoRequisito VARCHAR(255)  NOT NULL  ,
  obsTipoRequisito VARCHAR(255)  NULL    ,
PRIMARY KEY(idTipoRequisito));



CREATE TABLE usuario (
  idUsuario INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nomeUsuario VARCHAR(50)  NOT NULL  ,
  cpfUsuario CHAR(14)  NOT NULL  ,
  senhaUsuario VARCHAR(40)  NOT NULL  ,
  dataInclusaoUsuario CHAR(10)  NOT NULL  ,
  emailUsuario VARCHAR(45)  NOT NULL  ,
  tipoUsuario VARCHAR(20)  NOT NULL    ,
PRIMARY KEY(idUsuario));



CREATE TABLE ator (
  idAtor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  descAtor VARCHAR(35)  NULL  ,
  nomeAtor VARCHAR(45)  NOT NULL    ,
PRIMARY KEY(idAtor));



CREATE TABLE projeto (
  idProjeto INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  nomeProjeto VARCHAR(255)  NOT NULL  ,
  dataInicioProjeto CHAR(10)  NOT NULL  ,
  dataTerminoProjeto CHAR(10)  NOT NULL  ,
  visaoGeralProjeto VARCHAR(255)  NOT NULL  ,
  statusProjeto VARCHAR(20)  NOT NULL  ,
  questionarioProjeto VARCHAR(255)  NULL    ,
PRIMARY KEY(idProjeto)  ,
INDEX Projeto_FKIndex1(usuario_idUsuario),
  FOREIGN KEY(usuario_idUsuario)
    REFERENCES usuario(idUsuario)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);



CREATE TABLE diagrama (
  idDiagrama INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  ator_idAtor INTEGER UNSIGNED  NOT NULL  ,
  nomeDiagrama VARCHAR(65)  NOT NULL  ,
  imgDiagrama VARCHAR(45)  NOT NULL    ,
PRIMARY KEY(idDiagrama)  ,
INDEX Diagrama_FKIndex1(ator_idAtor)  ,
INDEX Diagrama_FKIndex2(projeto_idProjeto),
  FOREIGN KEY(ator_idAtor)
    REFERENCES ator(idAtor)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(projeto_idProjeto)
    REFERENCES projeto(idProjeto)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);



CREATE TABLE linkarProjeto (
  usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  projeto_idProjeto INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(usuario_idUsuario, projeto_idProjeto)  ,
INDEX Usuario_has_Projeto_FKIndex1(usuario_idUsuario)  ,
INDEX Usuario_has_Projeto_FKIndex2(projeto_idProjeto),
  FOREIGN KEY(usuario_idUsuario)
    REFERENCES usuario(idUsuario)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(projeto_idProjeto)
    REFERENCES projeto(idProjeto)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);



CREATE TABLE requisito (
  idRequisito INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  tipoRequisito_idTipoRequisito INTEGER UNSIGNED  NOT NULL  ,
  projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  nomeRequisito VARCHAR(255)  NOT NULL  ,
  descricaoRequisito VARCHAR(255)  NOT NULL  ,
  dataInicioRequisito VARCHAR(10)  NOT NULL  ,
  dataTerminoRequisito VARCHAR(10)  NOT NULL  ,
  importanciaRequisito VARCHAR(5)  NOT NULL  ,
  situacaoRequisito VARCHAR(9)  NULL    ,
PRIMARY KEY(idRequisito)  ,
INDEX Requisito_FKIndex1(projeto_idProjeto)  ,
INDEX Requisito_FKIndex3(tipoRequisito_idTipoRequisito),
  FOREIGN KEY(projeto_idProjeto)
    REFERENCES projeto(idProjeto)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(tipoRequisito_idTipoRequisito)
    REFERENCES tipoRequisito(idTipoRequisito)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);



CREATE TABLE tarefa (
  idTarefa INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  requisito_idRequisito INTEGER UNSIGNED  NOT NULL  ,
  tarefa_idTarefa INTEGER UNSIGNED  NULL  ,
  projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  nomeTarefa VARCHAR(255)  NOT NULL  ,
  dataInicioTarefa VARCHAR(10)  NOT NULL  ,
  dataTerminoTarefa VARCHAR(10)  NOT NULL  ,
  obsTarefa VARCHAR(255)  NULL    ,
PRIMARY KEY(idTarefa)  ,
INDEX Tarefa_FKIndex1(usuario_idUsuario)  ,
INDEX Tarefa_FKIndex2(projeto_idProjeto)  ,
INDEX Tarefa_FKIndex3(tarefa_idTarefa)  ,
INDEX tarefa_FKIndex4(requisito_idRequisito),
  FOREIGN KEY(usuario_idUsuario)
    REFERENCES usuario(idUsuario)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(projeto_idProjeto)
    REFERENCES projeto(idProjeto)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(tarefa_idTarefa)
    REFERENCES tarefa(idTarefa)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION,
  FOREIGN KEY(requisito_idRequisito)
    REFERENCES requisito(idRequisito)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);



CREATE TABLE casoDeUso (
  idCasoDeUso INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  diagrama_idDiagrama INTEGER UNSIGNED  NOT NULL  ,
  nomeCasoDeUso VARCHAR(150)  NOT NULL  ,
  fluxoCasoDeUso VARCHAR(255)  NOT NULL  ,
  resumoCasoDeUso VARCHAR(255)  NOT NULL  ,
  precondicaoCasoDeUso VARCHAR(255)  NOT NULL  ,
  fluxoAltCasoDeUso VARCHAR(255)  NOT NULL  ,
  excecaoCasoDeUso VARCHAR(255)  NULL  ,
  posCondicaoCasoDeUso VARCHAR(255)  NULL  ,
  regraNegocioCasoDeUso VARCHAR(255)  NULL    ,
PRIMARY KEY(idCasoDeUso)  ,
INDEX CasoDeUso_FKIndex1(diagrama_idDiagrama),
  FOREIGN KEY(diagrama_idDiagrama)
    REFERENCES diagrama(idDiagrama)
      ON DELETE RESTRICT
      ON UPDATE NO ACTION);




