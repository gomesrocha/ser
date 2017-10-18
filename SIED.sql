CREATE TABLE TipoRequisito (
  idTipoRequisito INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nomeTipoRequisito VARCHAR(255)  NOT NULL  ,
  obsTipoRequisito VARCHAR(255)  NULL    ,
PRIMARY KEY(idTipoRequisito));



CREATE TABLE Usuario (
  idUsuario INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nomeUsuario VARCHAR(50)  NOT NULL  ,
  cpfUsuario CHAR(14)  NOT NULL  ,
  senhaUsuario VARCHAR(40)  NOT NULL  ,
  dataInclusaoUsuario CHAR(10)  NOT NULL  ,
  emailUsuario VARCHAR(45)  NOT NULL  ,
  tipoUsuario VARCHAR(20)  NOT NULL    ,
PRIMARY KEY(idUsuario));



CREATE TABLE Ator (
  idAtor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  descAtor VARCHAR(35)  NULL  ,
  nomeAtor VARCHAR(45)  NOT NULL    ,
PRIMARY KEY(idAtor));



CREATE TABLE Projeto (
  idProjeto INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  Usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  nomeProjeto VARCHAR(255)  NOT NULL  ,
  dataInicioProjeto CHAR(10)  NOT NULL  ,
  dataTerminoProjeto CHAR(10)  NOT NULL  ,
  visaoGeralProjeto VARCHAR(255)  NOT NULL  ,
  statusProjeto VARCHAR(20)  NOT NULL  ,
  questionarioProjeto VARCHAR(255)  NULL    ,
PRIMARY KEY(idProjeto)  ,
INDEX Projeto_FKIndex1(Usuario_idUsuario),
  FOREIGN KEY(Usuario_idUsuario)
    REFERENCES Usuario(idUsuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE Diagrama (
  idDiagrama INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  Projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  Ator_idAtor INTEGER UNSIGNED  NOT NULL  ,
  nomeDiagrama VARCHAR(65)  NOT NULL  ,
  imgDiagrama VARCHAR(45)  NOT NULL    ,
PRIMARY KEY(idDiagrama)  ,
INDEX Diagrama_FKIndex1(Ator_idAtor)  ,
INDEX Diagrama_FKIndex2(Projeto_idProjeto),
  FOREIGN KEY(Ator_idAtor)
    REFERENCES Ator(idAtor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Projeto_idProjeto)
    REFERENCES Projeto(idProjeto)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE Tarefa (
  idTarefa INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  Tarefa_idTarefa INTEGER UNSIGNED  NULL  ,
  Projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  Usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  nomeTarefa VARCHAR(255)  NOT NULL  ,
  dataInicioTarefa VARCHAR(10)  NOT NULL  ,
  dataTerminoTarefa VARCHAR(10)  NOT NULL  ,
  obsTarefa VARCHAR(255)  NULL    ,
PRIMARY KEY(idTarefa)  ,
INDEX Tarefa_FKIndex1(Usuario_idUsuario)  ,
INDEX Tarefa_FKIndex2(Projeto_idProjeto)  ,
INDEX Tarefa_FKIndex3(Tarefa_idTarefa),
  FOREIGN KEY(Usuario_idUsuario)
    REFERENCES Usuario(idUsuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Projeto_idProjeto)
    REFERENCES Projeto(idProjeto)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Tarefa_idTarefa)
    REFERENCES Tarefa(idTarefa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE LinkarProjeto (
  Usuario_idUsuario INTEGER UNSIGNED  NOT NULL  ,
  Projeto_idProjeto INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(Usuario_idUsuario, Projeto_idProjeto)  ,
INDEX Usuario_has_Projeto_FKIndex1(Usuario_idUsuario)  ,
INDEX Usuario_has_Projeto_FKIndex2(Projeto_idProjeto),
  FOREIGN KEY(Usuario_idUsuario)
    REFERENCES Usuario(idUsuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Projeto_idProjeto)
    REFERENCES Projeto(idProjeto)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE Requisito (
  idRequisito INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  TipoRequisito_idTipoRequisito INTEGER UNSIGNED  NOT NULL  ,
  Tarefa_idTarefa INTEGER UNSIGNED  NOT NULL  ,
  Projeto_idProjeto INTEGER UNSIGNED  NOT NULL  ,
  nomeRequisito VARCHAR(255)  NOT NULL  ,
  descricaoRequisito VARCHAR(255)  NOT NULL  ,
  dataInicioRequisito VARCHAR(10)  NOT NULL  ,
  dataTerminoRequisito VARCHAR(10)  NOT NULL  ,
  importanciaRequisito VARCHAR(5)  NOT NULL  ,
  situacaoRequisito VARCHAR(9)  NULL    ,
PRIMARY KEY(idRequisito)  ,
INDEX Requisito_FKIndex1(Projeto_idProjeto)  ,
INDEX Requisito_FKIndex2(Tarefa_idTarefa)  ,
INDEX Requisito_FKIndex3(TipoRequisito_idTipoRequisito),
  FOREIGN KEY(Projeto_idProjeto)
    REFERENCES Projeto(idProjeto)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(Tarefa_idTarefa)
    REFERENCES Tarefa(idTarefa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(TipoRequisito_idTipoRequisito)
    REFERENCES TipoRequisito(idTipoRequisito)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE CasoDeUso (
  idCasoDeUso INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  Diagrama_idDiagrama INTEGER UNSIGNED  NOT NULL  ,
  nomeCasoDeUso VARCHAR(150)  NOT NULL  ,
  fluxoCasoDeUso VARCHAR(255)  NOT NULL  ,
  resumoCasoDeUso VARCHAR(255)  NOT NULL  ,
  precondicaoCasoDeUso VARCHAR(255)  NOT NULL  ,
  fluxoAltCasoDeUso VARCHAR(255)  NOT NULL  ,
  excecaoCasoDeUso VARCHAR(255)  NULL  ,
  posCondicaoCasoDeUso VARCHAR(255)  NULL  ,
  regraNegocioCasoDeUso VARCHAR(255)  NULL    ,
PRIMARY KEY(idCasoDeUso)  ,
INDEX CasoDeUso_FKIndex1(Diagrama_idDiagrama),
  FOREIGN KEY(Diagrama_idDiagrama)
    REFERENCES Diagrama(idDiagrama)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




