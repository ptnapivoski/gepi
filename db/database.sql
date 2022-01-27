-- Importante codificação para ampla compatibilidade de caracteres
SET NAMES utf8mb4;

-- SHOW DATABASES;

-- Caso exista o DB, exclui-o
DROP DATABASE IF EXISTS gepi;
-- Gera o DB com as devidas configurações de codificação
CREATE DATABASE IF NOT EXISTS gepi
	DEFAULT CHARACTER SET utf8mb4
	DEFAULT COLLATE utf8mb4_unicode_ci;
-- Seleciona o DB
USE gepi;

-- Exclusão de tabelas caso não possa executar as modificações no DB
DROP TABLE IF EXISTS permissao_e_entidade;
DROP TABLE IF EXISTS permissao_e_servico_de_hab;
DROP TABLE IF EXISTS permissao_e_servico_de_mob;
DROP TABLE IF EXISTS permissao_e_servico_de_ddpd;
DROP TABLE IF EXISTS permissao_e_servico_de_as;
DROP TABLE IF EXISTS permissao_e_servico_de_educacao;
DROP TABLE IF EXISTS permissao_e_servico_de_saude;
DROP TABLE IF EXISTS permissao_e_servico;
DROP TABLE IF EXISTS permissao_e_tipo_de_servico;
DROP TABLE IF EXISTS permissao_e_medicacao;
DROP TABLE IF EXISTS permissao_e_profissao;
DROP TABLE IF EXISTS permissao_e_vinculo_pessoal;
DROP TABLE IF EXISTS permissao_e_tipo_de_entidade;
DROP TABLE IF EXISTS permissao_e_tipo_de_residencia;
DROP TABLE IF EXISTS permissao_e_endereco;
DROP TABLE IF EXISTS permissao_e_bairro;
DROP TABLE IF EXISTS permissao_e_logradouro;
DROP TABLE IF EXISTS permissao_e_tipo_de_logradouro;
DROP TABLE IF EXISTS permissao_e_cidade;
DROP TABLE IF EXISTS permissao_e_uf;
DROP TABLE IF EXISTS permissao_e_pais;
DROP TABLE IF EXISTS permissao_e_adaptacao_arquitetonica;
DROP TABLE IF EXISTS permissao_e_barreira;
DROP TABLE IF EXISTS permissao_e_tecnologia;
DROP TABLE IF EXISTS permissao_e_beneficio;
DROP TABLE IF EXISTS permissao_e_raca;
DROP TABLE IF EXISTS permissao_e_turno_escolar;
DROP TABLE IF EXISTS permissao_e_serie_escolar;
DROP TABLE IF EXISTS permissao_e_escolaridade;
DROP TABLE IF EXISTS permissao_e_status_de_diagnostico;
DROP TABLE IF EXISTS permissao_e_diagnostico;
DROP TABLE IF EXISTS permissao_e_estado_civil;
DROP TABLE IF EXISTS permissao_e_genero;
DROP TABLE IF EXISTS acao;
DROP TABLE IF EXISTS historico;
DROP TABLE IF EXISTS secao_de_historico;
DROP TABLE IF EXISTS pessoa_fisica_e_cras_ou_creas;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_hab;
DROP TABLE IF EXISTS servico_de_hab;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_mob;
DROP TABLE IF EXISTS servico_de_mob;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_ddpd;
DROP TABLE IF EXISTS servico_de_ddpd;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_as;
DROP TABLE IF EXISTS servico_de_as;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_educacao;
DROP TABLE IF EXISTS servico_de_educacao;
DROP TABLE IF EXISTS pessoa_fisica_e_servico_de_saude;
DROP TABLE IF EXISTS servico_de_saude;
DROP TABLE IF EXISTS pessoa_fisica_e_servico;
DROP TABLE IF EXISTS servico;
DROP TABLE IF EXISTS tipo_de_servico;
DROP TABLE IF EXISTS pessoa_fisica_e_medicacao;
DROP TABLE IF EXISTS medicacao;
DROP TABLE IF EXISTS pessoa_fisica_e_interesse_em_trabalho;
DROP TABLE IF EXISTS pessoa_fisica_e_interesse_em_qualificacao;
DROP TABLE IF EXISTS pessoa_fisica_e_qualificacao;
DROP TABLE IF EXISTS pessoa_fisica_e_trabalho;
DROP TABLE IF EXISTS profissao;
DROP TABLE IF EXISTS pessoa_fisica_e_vinculo_pessoal;
DROP TABLE IF EXISTS vinculo_pessoal;
DROP TABLE IF EXISTS pessoa_fisica_e_escola;
DROP TABLE IF EXISTS endereco_e_adaptacao_arquitetonica;
DROP TABLE IF EXISTS pessoa_fisica_e_adaptacao_arquitetonica;
DROP TABLE IF EXISTS pessoa_fisica_e_barreira_no_trabalho;
DROP TABLE IF EXISTS pessoa_fisica_e_barreira_no_ensino;
DROP TABLE IF EXISTS pessoa_fisica_e_tecnologia;
DROP TABLE IF EXISTS pessoa_fisica_e_beneficio;
DROP TABLE IF EXISTS pessoa_fisica_e_diagnostico;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS email;
DROP TABLE IF EXISTS telefone;
DROP TABLE IF EXISTS pessoa_fisica;
DROP TABLE IF EXISTS entidade;
DROP TABLE IF EXISTS tipo_de_residencia;
DROP TABLE IF EXISTS endereco;
DROP TABLE IF EXISTS bairro;
DROP TABLE IF EXISTS logradouro;
DROP TABLE IF EXISTS tipo_de_logradouro;
DROP TABLE IF EXISTS cidade;
DROP TABLE IF EXISTS uf;
DROP TABLE IF EXISTS pais;
DROP TABLE IF EXISTS tipo_de_entidade;
DROP TABLE IF EXISTS adaptacao_arquitetonica;
DROP TABLE IF EXISTS barreira;
DROP TABLE IF EXISTS tecnologia;
DROP TABLE IF EXISTS beneficio;
DROP TABLE IF EXISTS raca;
DROP TABLE IF EXISTS turno_escolar;
DROP TABLE IF EXISTS serie_escolar;
DROP TABLE IF EXISTS escolaridade;
DROP TABLE IF EXISTS status_de_diagnostico;
DROP TABLE IF EXISTS diagnostico;
DROP TABLE IF EXISTS estado_civil;
DROP TABLE IF EXISTS genero;

-- Propriedade nominal de gênero de pessoa física
CREATE TABLE IF NOT EXISTS genero (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Propriedade nominal de estado civil de pessoa física
CREATE TABLE IF NOT EXISTS estado_civil (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Diagnósticos possíveis de uma pessoa física
CREATE TABLE IF NOT EXISTS diagnostico (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
	,cid  VARCHAR(255) UNIQUE
);

-- Possíveis status de um diagnóstico dado a uma pessoa física
CREATE TABLE IF NOT EXISTS status_de_diagnostico (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Propriedade nominal escolaridade de uma pessoa física
CREATE TABLE IF NOT EXISTS escolaridade (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Séries escolares que uma pessoa física pode cursar
CREATE TABLE IF NOT EXISTS serie_escolar (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Possíveis turnos escolares a cursar
CREATE TABLE IF NOT EXISTS turno_escolar (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Propriedade nominal raça de uma pessoa física
CREATE TABLE IF NOT EXISTS raca (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Benefícios que uma pessoa física pode receber
CREATE TABLE IF NOT EXISTS beneficio (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Tecnologia a que uma pessoa física pode ter acesso
CREATE TABLE IF NOT EXISTS tecnologia (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Barreiras que uma pessoa física pode encontrar
CREATE TABLE IF NOT EXISTS barreira (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Adaptações arquitetônicas que uma pessoa física pode precisar
CREATE TABLE IF NOT EXISTS adaptacao_arquitetonica (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Possíveis tipos de entidade
CREATE TABLE IF NOT EXISTS tipo_de_entidade (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Países
CREATE TABLE IF NOT EXISTS pais (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Unidade Federativas de um país
CREATE TABLE IF NOT EXISTS uf (
	 id    BIGINT UNSIGNED AUTO_INCREMENT KEY
	,pais  BIGINT UNSIGNED NOT NULL
	,sigla VARCHAR(255)
	,nome  VARCHAR(255) NOT NULL
	,UNIQUE (pais,nome)
	,FOREIGN KEY (pais)
		REFERENCES pais (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Cidades de uma Unidade Federativa
CREATE TABLE IF NOT EXISTS cidade (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,uf   BIGINT UNSIGNED NOT NULL
	,nome VARCHAR(255) NOT NULL
	,UNIQUE (uf,nome)
	,FOREIGN KEY (uf)
		REFERENCES uf (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Possíveis tipos de logradouro
CREATE TABLE IF NOT EXISTS tipo_de_logradouro (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Logradouros de cada cidade
CREATE TABLE IF NOT EXISTS logradouro (
	 id                 BIGINT UNSIGNED AUTO_INCREMENT KEY
	,cidade             BIGINT UNSIGNED NOT NULL
	,tipo_de_logradouro BIGINT UNSIGNED NOT NULL
	,nome               VARCHAR(255) NOT NULL
	,UNIQUE (cidade,tipo_de_logradouro,nome)
	,FOREIGN KEY (cidade)
		REFERENCES cidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (tipo_de_logradouro)
		REFERENCES tipo_de_logradouro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Bairros de cada cidade
CREATE TABLE IF NOT EXISTS bairro (
	 id     BIGINT UNSIGNED AUTO_INCREMENT KEY
	,cidade BIGINT UNSIGNED NOT NULL
	,nome   VARCHAR(255) NOT NULL
	,UNIQUE (cidade,nome)
	,FOREIGN KEY (cidade)
		REFERENCES cidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Endereços ou Residências para serem vinculados às entidades cadastradas
CREATE TABLE IF NOT EXISTS endereco (
	 id          BIGINT UNSIGNED AUTO_INCREMENT KEY
	,bairro      BIGINT UNSIGNED NOT NULL
	,logradouro  BIGINT UNSIGNED NOT NULL
	,numero      BIGINT UNSIGNED
	,complemento VARCHAR(255)
	,cep         VARCHAR(255)
	,geocodigo   BIGINT UNSIGNED
	,geom        GEOMETRY
	,FOREIGN KEY (bairro)
		REFERENCES bairro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (logradouro)
		REFERENCES logradouro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Propriedade nominal de tipo de residência de pessoa física
CREATE TABLE IF NOT EXISTS tipo_de_residencia (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Entidades cadastradas
CREATE TABLE IF NOT EXISTS entidade (
	 id               BIGINT UNSIGNED AUTO_INCREMENT KEY
	,tipo_de_entidade BIGINT UNSIGNED NOT NULL
	,inserido_por     BIGINT UNSIGNED
	,endereco         BIGINT UNSIGNED
	,nome             VARCHAR(255) NOT NULL
	,FOREIGN KEY (tipo_de_entidade)
		REFERENCES tipo_de_entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (inserido_por)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (endereco)
		REFERENCES endereco (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
);

-- Pessoa física como especialização de entidade
CREATE TABLE IF NOT EXISTS pessoa_fisica (
	 id                     BIGINT UNSIGNED KEY
	,nascimento             DATE
	,cpf                    VARCHAR(255) UNIQUE
	,rg                     VARCHAR(255) UNIQUE
	,sus                    VARCHAR(255) UNIQUE
	,nis                    VARCHAR(255) UNIQUE
	,certidao_de_nascimento VARCHAR(255) UNIQUE
	,genero                 BIGINT UNSIGNED
	,raca                   BIGINT UNSIGNED
	,estado_civil           BIGINT UNSIGNED
	,renda                  DOUBLE
	,escolaridade           BIGINT UNSIGNED
	,naturalidade           BIGINT UNSIGNED
	,tipo_de_residencia     BIGINT UNSIGNED
	,FOREIGN KEY (id)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (genero)
		REFERENCES genero (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (raca)
		REFERENCES raca (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (estado_civil)
		REFERENCES estado_civil (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (escolaridade)
		REFERENCES escolaridade (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (naturalidade)
		REFERENCES cidade (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
	,FOREIGN KEY (tipo_de_residencia)
		REFERENCES tipo_de_residencia (id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
);

-- Telefones de cada entidade
CREATE TABLE IF NOT EXISTS telefone (
	 entidade BIGINT UNSIGNED
	,telefone VARCHAR(255)
	,obs      VARCHAR(255)
	,PRIMARY KEY (entidade,telefone)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Emails de cada entidade
CREATE TABLE IF NOT EXISTS email (
	 entidade BIGINT UNSIGNED
	,email    VARCHAR(255)
	,PRIMARY KEY (entidade,email)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Cada entidade pode ou não ter uma senha para executar ações
CREATE TABLE IF NOT EXISTS usuario (
	 id    BIGINT UNSIGNED KEY
	,senha VARCHAR(255) NOT NULL
	,FOREIGN KEY (id)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de diagnósticos de cada pessoa física cadastrada
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_diagnostico (
	 pessoa_fisica         BIGINT UNSIGNED
	,diagnostico           BIGINT UNSIGNED
	,permanente            BOOLEAN NOT NULL
	,status_de_diagnostico BIGINT UNSIGNED NOT NULL
	,PRIMARY KEY (pessoa_fisica,diagnostico)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (diagnostico)
		REFERENCES diagnostico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (status_de_diagnostico)
		REFERENCES status_de_diagnostico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de benefícios de cada pessoa física cadastrada
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_beneficio (
	 pessoa_fisica BIGINT UNSIGNED
	,beneficio     BIGINT UNSIGNED
	,quantidade    DOUBLE NOT NULL
	,PRIMARY KEY (pessoa_fisica,beneficio)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (beneficio)
		REFERENCES beneficio (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de tecnologias a que uma pessoa física tem acesso
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_tecnologia (
	 pessoa_fisica BIGINT UNSIGNED
	,tecnologia    BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,tecnologia)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (tecnologia)
		REFERENCES tecnologia (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de barreiras no ensino encontradas por uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_barreira_no_ensino (
	 pessoa_fisica      BIGINT UNSIGNED
	,barreira_no_ensino BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,barreira_no_ensino)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (barreira_no_ensino)
		REFERENCES barreira (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de barreiras no trabalho encontradas por uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_barreira_no_trabalho (
	 pessoa_fisica        BIGINT UNSIGNED
	,barreira_no_trabalho BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,barreira_no_trabalho)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (barreira_no_trabalho)
		REFERENCES barreira (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de adaptações arquitetônicas que uma pessoa física pode precisar
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_adaptacao_arquitetonica (
	 pessoa_fisica           BIGINT UNSIGNED
	,adaptacao_arquitetonica BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,adaptacao_arquitetonica)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (adaptacao_arquitetonica)
		REFERENCES adaptacao_arquitetonica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de adaptações arquitetônicas presentes em um endereço
CREATE TABLE IF NOT EXISTS endereco_e_adaptacao_arquitetonica (
	 endereco                BIGINT UNSIGNED
	,adaptacao_arquitetonica BIGINT UNSIGNED
	,PRIMARY KEY (endereco,adaptacao_arquitetonica)
	,FOREIGN KEY (endereco)
		REFERENCES endereco (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (adaptacao_arquitetonica)
		REFERENCES adaptacao_arquitetonica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de histórico escolar de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_escola (
	 pessoa_fisica BIGINT UNSIGNED
	,ano           YEAR
	,escola        BIGINT UNSIGNED
	,serie_escolar BIGINT UNSIGNED NOT NULL
	,turno_escolar BIGINT UNSIGNED NOT NULL
	,frequencia    DOUBLE
	,repetencia    BIGINT UNSIGNED NOT NULL
	,PRIMARY KEY (pessoa_fisica,ano,escola,serie_escolar)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (escola)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (serie_escolar)
		REFERENCES serie_escolar (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (turno_escolar)
		REFERENCES turno_escolar (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Vínculos pessoais possíveis entre pessoas físicas
CREATE TABLE IF NOT EXISTS vinculo_pessoal (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de vínculos entre pessoas físicas
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_vinculo_pessoal (
	 pessoa_fisica BIGINT UNSIGNED
	,eh            BIGINT UNSIGNED
	,de            BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,eh,de)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (eh)
		REFERENCES vinculo_pessoal (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (de)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Possíveis profissões
CREATE TABLE IF NOT EXISTS profissao (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de histórico de trabalho entre pessoas físicas e entidades
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_trabalho (
	 pessoa_fisica BIGINT UNSIGNED
	,para          BIGINT UNSIGNED
	,como          BIGINT UNSIGNED
	,passado       BOOLEAN NOT NULL
	,PRIMARY KEY (pessoa_fisica,para,como)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (para)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (como)
		REFERENCES profissao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de qualificações para o trabalho de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_qualificacao (
	 pessoa_fisica BIGINT UNSIGNED
	,qualificacao  BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,qualificacao)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (qualificacao)
		REFERENCES profissao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de interesses em qualificações que uma pessoa física tem
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_interesse_em_qualificacao (
	 pessoa_fisica BIGINT UNSIGNED
	,interesse     BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,interesse)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (interesse)
		REFERENCES profissao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de interesse em trabalho que uma pessoa física tem
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_interesse_em_trabalho (
	 pessoa_fisica BIGINT UNSIGNED
	,interesse     BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,interesse)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (interesse)
		REFERENCES profissao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Medicação
CREATE TABLE IF NOT EXISTS medicacao (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de pessoa física e uso de medicações
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_medicacao (
	 pessoa_fisica BIGINT UNSIGNED
	,medicacao  BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,medicacao)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (medicacao)
		REFERENCES medicacao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Tipos de serviço
CREATE TABLE IF NOT EXISTS tipo_de_servico (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Serviços
CREATE TABLE IF NOT EXISTS servico (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,tipo_de_servico  BIGINT UNSIGNED NOT NULL
	,nome VARCHAR(255) NOT NULL
	,UNIQUE (tipo_de_servico,nome)
	,FOREIGN KEY (tipo_de_servico)
		REFERENCES tipo_de_servico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de uso de serviço de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de saúde
CREATE TABLE IF NOT EXISTS servico_de_saude (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de serviço de saúde de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_saude (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_saude (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de educação
CREATE TABLE IF NOT EXISTS servico_de_educacao (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de serviço de educação de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_educacao (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_educacao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de assistência social
CREATE TABLE IF NOT EXISTS servico_de_as (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de serviço de assistência social de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_as (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_as (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de Defesa dos Direitos da Pessoa com Deficiência
CREATE TABLE IF NOT EXISTS servico_de_ddpd (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de Serviços de Defesa dos Direitos da Pessoa com Deficiência de uma pessoa física
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_ddpd (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_ddpd (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de Mobilidade Urbana
CREATE TABLE IF NOT EXISTS servico_de_mob (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de serviço de Mobilidade Urbana
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_mob (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_mob (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Serviços de Habitação
CREATE TABLE IF NOT EXISTS servico_de_hab (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Relação de uso de serviço de Habitação
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_servico_de_hab (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES servico_de_hab (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Relação de uso de CRAS ou CREAS
CREATE TABLE IF NOT EXISTS pessoa_fisica_e_cras_ou_creas (
	 pessoa_fisica BIGINT UNSIGNED
	,uso           BIGINT UNSIGNED
	,PRIMARY KEY (pessoa_fisica,uso)
	,FOREIGN KEY (pessoa_fisica)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (uso)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Propriedade seção em histórico
CREATE TABLE IF NOT EXISTS secao_de_historico (
	 id   BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome VARCHAR(255) NOT NULL UNIQUE
);

-- Histórico de informações compartilhadas entre as entidades
CREATE TABLE IF NOT EXISTS historico (
	 entidade  BIGINT UNSIGNED
	,sobre     BIGINT UNSIGNED
	,secao     BIGINT UNSIGNED
	,quando    DATETIME
	,titulo    VARCHAR(255) NOT NULL
	,descricao TEXT NOT NULL
	,arquivo   VARCHAR(255)
	,PRIMARY KEY (entidade,sobre,quando)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (sobre)
		REFERENCES pessoa_fisica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (secao)
		REFERENCES secao_de_historico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Ações possíveis de serem executadas na aplicação
CREATE TABLE IF NOT EXISTS acao (
	 id         BIGINT UNSIGNED AUTO_INCREMENT KEY
	,nome       VARCHAR(255) NOT NULL UNIQUE
	,tem_objeto BOOLEAN NOT NULL
);

-- Permissões sobre gêneros
CREATE TABLE IF NOT EXISTS permissao_e_genero (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES genero (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre estados civis
CREATE TABLE IF NOT EXISTS permissao_e_estado_civil (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES estado_civil (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre diagnósticos
CREATE TABLE IF NOT EXISTS permissao_e_diagnostico (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES diagnostico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre status de diagnósticos
CREATE TABLE IF NOT EXISTS permissao_e_status_de_diagnostico (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES status_de_diagnostico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre escolaridades
CREATE TABLE IF NOT EXISTS permissao_e_escolaridade (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES escolaridade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre séries escolares
CREATE TABLE IF NOT EXISTS permissao_e_serie_escolar (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES serie_escolar (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre turnos escolares
CREATE TABLE IF NOT EXISTS permissao_e_turno_escolar (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES turno_escolar (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre raças
CREATE TABLE IF NOT EXISTS permissao_e_raca (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES raca (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre benefícios
CREATE TABLE IF NOT EXISTS permissao_e_beneficio (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES beneficio (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre tecnologias
CREATE TABLE IF NOT EXISTS permissao_e_tecnologia (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES tecnologia (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre barreiras
CREATE TABLE IF NOT EXISTS permissao_e_barreira (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES barreira (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre adaptações arquitetônicas
CREATE TABLE IF NOT EXISTS permissao_e_adaptacao_arquitetonica (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES adaptacao_arquitetonica (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre países
CREATE TABLE IF NOT EXISTS permissao_e_pais (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES pais (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre unidades federativas
CREATE TABLE IF NOT EXISTS permissao_e_uf (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES uf (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre cidades
CREATE TABLE IF NOT EXISTS permissao_e_cidade (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES cidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre tipos de logradouros
CREATE TABLE IF NOT EXISTS permissao_e_tipo_de_logradouro (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES tipo_de_logradouro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre logradouros
CREATE TABLE IF NOT EXISTS permissao_e_logradouro (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES logradouro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre bairros
CREATE TABLE IF NOT EXISTS permissao_e_bairro (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES bairro (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre endereços
CREATE TABLE IF NOT EXISTS permissao_e_endereco (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES endereco (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre tipos de residência
CREATE TABLE IF NOT EXISTS permissao_e_tipo_de_residencia (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES tipo_de_residencia (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre tipos de entidade
CREATE TABLE IF NOT EXISTS permissao_e_tipo_de_entidade (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES tipo_de_entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre vínculos pessoais
CREATE TABLE IF NOT EXISTS permissao_e_vinculo_pessoal (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES vinculo_pessoal (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre profissões
CREATE TABLE IF NOT EXISTS permissao_e_profissao (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES profissao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre medicações
CREATE TABLE IF NOT EXISTS permissao_e_medicacao (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES medicacao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre tipos de serviços
CREATE TABLE IF NOT EXISTS permissao_e_tipo_de_servico (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES tipo_de_servico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços
CREATE TABLE IF NOT EXISTS permissao_e_servico (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de saúde
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_saude (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_saude (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de educação
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_educacao (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_educacao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de assistência social
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_as (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_as (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de defesa dos direitos da pessoa com deficiência
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_ddpd (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_ddpd (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de mobilidade
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_mob (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_mob (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre serviços de habitação
CREATE TABLE IF NOT EXISTS permissao_e_servico_de_hab (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES servico_de_hab (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Permissões sobre entidades
CREATE TABLE IF NOT EXISTS permissao_e_entidade (
	 entidade BIGINT UNSIGNED
	,pode     BOOLEAN NOT NULL
	,acao     BIGINT UNSIGNED
	,com      BIGINT UNSIGNED
	,UNIQUE (entidade,acao,com)
	,FOREIGN KEY (entidade)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (acao)
		REFERENCES acao (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	,FOREIGN KEY (com)
		REFERENCES entidade (id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

-- Populando dados iniciais

-- Gêneros iniciais
INSERT INTO genero (nome) VALUES
 (/*1*/'Feminino (cis)')
,(/*2*/'Masculino (cis)')
,(/*3*/'Feminino (trans)')
,(/*4*/'Masculino (trans)')
;

-- Estados civis iniciais
INSERT INTO estado_civil (nome) VALUES
 (/*1*/'Solteiro(a)')
,(/*2*/'Casado(a)')
,(/*3*/'Divorciado(a)')
,(/*4*/'União estável')
,(/*5*/'Separado(a)')
,(/*6*/'Viúvo(a)')
;

-- Diagnósticos iniciais
INSERT INTO diagnostico (nome,cid) VALUES
 ('Def. visual - Baixa visão',NULL)
,('Def. visual - Cegueira e visão subnormal',NULL)
,('Def. visual - Cegueira em um olho',NULL)
,('Def. visual - Cegueira em um olho e visão subnormal em outro',NULL)
,('Def. visual - Cegueira noturna',NULL)
,('Def. visual - Cegueira, ambos os olhos',NULL)
,('Def. visual - Defeitos do campo visual',NULL)
,('Def. visual - Distúrbio visual não especificado',NULL)
,('Def. visual - Visão subnormal de ambos os olhos',NULL)
,('Def. visual - Visão subnormal em um olho',NULL)
,('Def. física - Ausência de membros',NULL)
,('Def. física - Deformidades adquiridas dos membros inferiores',NULL)
,('Def. física - Deformidades adquiridas dos membros superiores',NULL)
,('Def. física - Hemiplegia',NULL)
,('Def. física - Mobilidade Reduzida',NULL)
,('Def. física - Monoplegia',NULL)
,('Def. física - Nanismo',NULL)
,('Def. física - Ostogênese Imperfeita',NULL)
,('Def. física - Ostomia',NULL)
,('Def. física - Paraplegia',NULL)
,('Def. física - Talidomida',NULL)
,('Def. física - Tetraplegia',NULL)
,('Def. auditiva - Implante coclear',NULL)
,('Def. auditiva - Malformações congênitas do ouvido causando comprometimento da audição',NULL)
,('Def. auditiva - Perda de audição bilateral (total)',NULL)
,('Def. auditiva - Perda de audição súbita idiopática',NULL)
,('Def. auditiva - Perda de audição unilateral (parcial)',NULL)
,('Def. auditiva - Presbiacusia',NULL)
,('Def. auditiva - Presença de aparelho externo de surdez',NULL)
,('Def. auditiva - Surdez',NULL)
,('Def. auditiva - Surdocegueira',NULL)
,('Def. intelectual - Retardo mental grave',NULL)
,('Def. intelectual - Retardo mental leve',NULL)
,('Def. intelectual - Retardo mental moderado',NULL)
,('Def. intelectual - Retardo mental profundo',NULL)
,('Def. múltipla - Paralisia cerebral',NULL)
,('Def. múltipla - Paralisia cerebral atáxica',NULL)
,('Def. múltipla - Paralisia cerebral diplégica espástica',NULL)
,('Def. múltipla - Paralisia cerebral discinética',NULL)
,('Def. múltipla - Paralisia cerebral hemiplégica espástica',NULL)
,('Def. múltipla - Paralisia cerebral não especificada',NULL)
,('Def. múltipla - Paralisia cerebral quadriplágica espástica',NULL)
,('Def. múltipla - Paralisia das cordas vocais e da laringe',NULL)
,('Def. múltipla - Paralisia de Bell',NULL)
,('Def. múltipla - Paralisia de Erb devida a traumatismo de parto',NULL)
,('Def. múltipla - Paralisia de Klumpke devida a traumatismo de parto',NULL)
,('Def. múltipla - Paralisia do nervo frênico devida a traumatismo de parto',NULL)
,('Def. múltipla - Paralisia do olhar conjugado',NULL)
,('Def. múltipla - Paralisia do quarto par (troclear)',NULL)
,('Def. múltipla - Paralisia do sexto par (abducente)',NULL)
,('Def. múltipla - Paralisia do terceiro par (oculomotor)',NULL)
,('Def. múltipla - Paralisia periódica',NULL)
,('Def. múltipla - Paralisias de múltiplos nervos cranianos em doenças infecciosas e parasitárias classificadas em outra parte',NULL)
,('Def. múltipla - Paralisias de múltiplos nervos cranianos em doenças neoplásicas',NULL)
,('Def. múltipla - Paralisias de múltiplos nervos cranianos na sarcoidose',NULL)
,('Síndrome - Desmatemática',NULL)
,('Síndrome - Dislexia',NULL)
,('Síndrome - Distúrbios da leitura e escrita',NULL)
,('Síndrome - Down',NULL)
,('Síndrome - Rett',NULL)
,('Síndrome - TEA',NULL)
,('Síndrome - THDA',NULL)
,('Síndrome - Tourette',NULL)
,('Síndrome - X-frágil',NULL)
,('Transtorno mental',NULL)
,('Altas habilidades',NULL)
;

-- Status de diagnósticos iniciais
INSERT INTO status_de_diagnostico (nome) VALUES
 (/*1*/'Estável')
,(/*2*/'Progressivo(a)')
,(/*3*/'Regressivo(a)')
;

-- Escolaridades iniciais
INSERT INTO escolaridade (nome) VALUES
 (/*01*/'Nenhuma')
,(/*02*/'Cursando ensino fundamental')
,(/*03*/'Ensino fundamental incompleto')
,(/*04*/'Ensino fundamental completo')
,(/*05*/'Cursando ensino médio')
,(/*06*/'Ensino médio incompleto')
,(/*07*/'Ensino médio completo')
,(/*08*/'Cursando ensino superior')
,(/*09*/'Ensino superior incompleto')
,(/*10*/'Ensino superior completo')
,(/*11*/'Pós-graduação')
;

-- Séries escolares iniciais
INSERT INTO serie_escolar (nome) VALUES
 (/*01*/'Berçário')
,(/*02*/'Maternal 1')
,(/*03*/'Maternal 2')
,(/*04*/'Pré-escolar 1')
,(/*05*/'Pré-escolar 2')
,(/*06*/'1º ano do ensino fundamental')
,(/*07*/'2º ano do ensino fundamental')
,(/*08*/'3º ano do ensino fundamental')
,(/*09*/'4º ano do ensino fundamental')
,(/*10*/'5º ano do ensino fundamental')
,(/*11*/'6º ano do ensino fundamental')
,(/*12*/'7º ano do ensino fundamental')
,(/*13*/'8º ano do ensino fundamental')
,(/*14*/'9º ano do ensino fundamental')
,(/*15*/'1º ano do ensino médio')
,(/*16*/'2º ano do ensino médio')
,(/*17*/'3º ano do ensino médio')
,(/*18*/'Classe especial')
;

-- Turnos escolares iniciais
INSERT INTO turno_escolar (nome) VALUES
 (/*1*/'Manhã')
,(/*2*/'Tarde')
,(/*3*/'Noite')
;

-- Raças iniciais
INSERT INTO raca (nome) VALUES
 (/*1*/'Branco(a)')
,(/*2*/'Negro(a)')
,(/*3*/'Pardo(a)')
,(/*4*/'Amarelo(a)')
,(/*5*/'Indígena')
;

-- Benefícios iniciais
INSERT INTO beneficio (nome) VALUES
 ('BPC')
,('Bolsa família')
;

-- Tecnologias iniciais
INSERT INTO tecnologia (nome) VALUES
 ('Andador')
,('Cadeira de rodas')
,('Celular')
,('Computador pessoal')
,('Guia')
,('Internet')
;

-- Barreiras iniciais
INSERT INTO barreira (nome) VALUES
 ('Arquitetônica')
,('Transporte')
;

-- Adaptações arquitetônicas iniciais
INSERT INTO adaptacao_arquitetonica (nome) VALUES
 ('Aberturas em tamanho maior/adequado')
,('Barra de apoio nas paredes do banheiro')
,('Barra tipo trapézio')
,('Barras de segurança')
,('Cama com altura ajustável')
,('Cama motorizada')
,('Campainha de emergência')
,('Corrimão de acesso')
,('Elevadores')
,('Lavabos e pias em alturas acessíveis')
,('Mobiliários adaptados')
,('Nivelamento de piso')
,('Piso antiderrapante')
,('Piso podotátil')
,('Rampas')
,('Sinais luminosos')
,('Vasos sanitários adaptados')
;

-- Profissões iniciais
INSERT INTO profissao (nome) VALUES
 ('Administrador(a)')
,('Advogado(a)')
,('Analista de Sistemas')
,('Aposentado(a)')
,('Arqueólogo(a)')
,('Artista Plástico(a)')
,('Biólogo(a)')
,('Biblioteconomista')
,('Cadista')
,('Caixa')
,('Cobrador(a) de Ônibus')
,('Cobrador(a) de Pedágio')
,('Contabilista')
,('Designer Gráfico')
,('Designer de Interiores')
,('Diarista')
,('Do lar')
,('Economista')
,('Empregado(a) Doméstico(a)')
,('Enfermeiro(a)')
,('Engenheiro(a) Bioquímico(a)')
,('Engenheiro(a) Civil')
,('Engenheiro(a) Mecânico(a)')
,('Engenheiro(a) Químico(a)')
,('Engenheiro(a) de Alimentos')
,('Engenheiro(a) de Automação')
,('Engenheiro(a) de Computação')
,('Engenheiro(a) de Produção')
,('Físico(a)')
,('Geógrafo(a)')
,('Historiador(a)')
,('Médico(a)')
,('Matemático(a)')
,('Militar')
,('Motorista Autônomo(a)')
,('Motorista Particular')
,('Motorista de Caminhão')
,('Motorista de Mototáxi')
,('Motorista de Táxi')
,('Oceanólogo(a)')
,('Pedagogo(a)')
,('Professor(a)')
,('Programador(a)')
,('Psicólogo(a)')
,('Químico(a)')
,('Soldador(a)')
,('Técnico(a) em Segurança do Trabalho')
,('Vendedor(a)')
,('Web Designer')
;

-- Tipos de entidade iniciais
INSERT INTO tipo_de_entidade (nome) VALUES
 (/*01*/'Pessoa Física')
,(/*02*/'Pessoa Jurídica')
,(/*03*/'Prefeitura')
,(/*04*/'Secretaria')
,(/*05*/'Escola Municipal')
,(/*06*/'Escola Estadual')
,(/*07*/'Escola Federal')
,(/*08*/'Escola Particular')
,(/*09*/'Escola Filantrópica')
,(/*10*/'UBS')
,(/*11*/'CRAS')
,(/*12*/'CREAS')
;

-- Países iniciais
INSERT INTO pais (nome) VALUES
 ('Brasil')
,('Uruguai')
;

-- Unidades federativas iniciais
INSERT INTO uf (pais,sigla,nome) VALUES
 (/*01*/1,'AC','Acre')
,(/*02*/1,'AL','Alagoas')
,(/*03*/1,'AM','Amazonas')
,(/*04*/1,'AP','Amapá')
,(/*05*/1,'BA','Bahia')
,(/*06*/1,'CE','Ceará')
,(/*07*/1,'DF','Distrito Federal')
,(/*08*/1,'ES','Espírito Santo')
,(/*09*/1,'GO','Goiás')
,(/*10*/1,'MA','Maranhão')
,(/*11*/1,'MG','Minas Gerais')
,(/*12*/1,'MS','Mato Grosso do Sul')
,(/*13*/1,'MT','Mato Grosso')
,(/*14*/1,'PA','Pará')
,(/*15*/1,'PB','Paraíba')
,(/*16*/1,'PE','Pernambuco')
,(/*17*/1,'PI','Piauí')
,(/*18*/1,'PR','Paraná')
,(/*19*/1,'RJ','Rio de Janeiro')
,(/*20*/1,'RN','Rio Grande do Norte')
,(/*21*/1,'RO','Rondônia')
,(/*22*/1,'RR','Roraima')
,(/*23*/1,'RS','Rio Grande do Sul')
,(/*24*/1,'SC','Santa Catarina')
,(/*25*/1,'SE','Sergipe')
,(/*26*/1,'SP','São Paulo')
,(/*27*/1,'TO','Tocantins')
;

-- Cidades iniciais
INSERT INTO cidade (uf,nome) VALUES
 (23,'Rio Grande')
,(23,'Pelotas')
,(23,'São José do Norte')
;

-- Tipos de logradouro iniciais
INSERT INTO tipo_de_logradouro (nome) VALUES
 (/*1*/'Alameda')
,(/*2*/'Avenida')
,(/*3*/'Beco')
,(/*4*/'Corredor')
,(/*5*/'Estrada')
,(/*6*/'Largo')
,(/*7*/'Rodovia')
,(/*8*/'Rua')
,(/*9*/'Travessa')
;

-- Logradouros iniciais
INSERT INTO logradouro (cidade,tipo_de_logradouro,nome) VALUES
 (1,6,'Engenheiro João Fernandes Moreira')
,(1,1,'Jandyr Garcia')
,(1,1,'Padre Francisco')
,(1,1,'Uruguay')
,(1,1,'das Esperanças')
,(1,2,'A')
,(1,2,'Almirante Maximiniano da Fonseca')
,(1,2,'Almirante Tamandaré')
,(1,2,'Argentina')
,(1,2,'Atlântica')
,(1,2,'B')
,(1,2,'Belo Brum')
,(1,2,'Brasil')
,(1,2,'Buarque de Macedo')
,(1,2,'C')
,(1,2,'Cassino')
,(1,2,'Cidade de Pelotas')
,(1,2,'Coronel Augusto Cesar Leivas')
,(1,2,'D')
,(1,2,'Dom Pedro II')
,(1,2,'Engenheira Lúcia Maria Balbela Chiesa')
,(1,2,'EngenheiroÊnio Rodrigues Maurer')
,(1,2,'F')
,(1,2,'Honório Bicalho')
,(1,2,'Itália')
,(1,2,'José Bonifácio')
,(1,2,'Luiz Leivas Otero')
,(1,2,'Major Assumpção')
,(1,2,'Major Carlos Pinto')
,(1,2,'Modesto Rey Dornelles')
,(1,2,'Nova Atlântica')
,(1,2,'Osvaldo Aranha')
,(1,2,'Osvaldo Cruz')
,(1,2,'Osvaldo Martensen')
,(1,2,'Portugal')
,(1,2,'Presidente Juscelino')
,(1,2,'Presidente Vargas')
,(1,2,'Primeiro de Maio')
,(1,2,'Quinze de Novembro')
,(1,2,'Rheingantz')
,(1,2,'Rio Grande')
,(1,2,'Santos Dumont')
,(1,2,'Tramandaí')
,(1,2,'das Bases')
,(1,2,'das Enseadas')
,(1,2,'dos Arquipélagos')
,(1,2,'dos Bandeirantes')
,(1,2,'dos Grandes Lagos')
,(1,2,'dos Oceanos')
,(1,3,'da Servidão')
,(1,4,'Doutor Waldemar Fetter')
,(1,4,'São Pedro')
,(1,4,'Segundo Corredor do Senandes')
,(1,4,'da Colônia')
,(1,4,'do Bosque Silveira')
,(1,5,'RG 175')
,(1,5,'RG 460')
,(1,5,'Roberto Socoowski')
,(1,5,'São Pedro')
,(1,5,'dos Franceses')
,(1,7,'BR 392')
,(1,7,'BR 471')
,(1,7,'RS 734')
,(1,8,'Álamos')
,(1,8,'Álvares Cabral')
,(1,8,'Álvaro Delfino')
,(1,8,'Ângelo Trindade')
,(1,8,'Érico Gama')
,(1,8,'Ílton Macedo Gonçalves')
,(1,8,'Írio Rodrigues – O Poeta Pobre')
,(1,8,'Abdala Nader')
,(1,8,'Acácia Rio Grandense')
,(1,8,'Acre')
,(1,8,'Adão dos Santos Vaz')
,(1,8,'Adel Carvalho')
,(1,8,'Advogado Victor Sacaven')
,(1,8,'Agenor Oliveira Costa')
,(1,8,'Alípio Cadaval')
,(1,8,'Alberto Miranda')
,(1,8,'Alberto Tôrres')
,(1,8,'Alberto de Oliveira')
,(1,8,'Albuquerque Libório')
,(1,8,'Aldo Dapuzzo')
,(1,8,'Allan Kardec')
,(1,8,'Almirante Barroso')
,(1,8,'Almirante Maximiano Fonseca')
,(1,8,'Almirante Teixeira')
,(1,8,'Altamir de Lacerda Nascimento')
,(1,8,'América')
,(1,8,'Américo Vespúcio')
,(1,8,'Amapá')
,(1,8,'Amauri Santos')
,(1,8,'André De Oliveira Salomão')
,(1,8,'Andradas')
,(1,8,'Andrade Neves')
,(1,8,'Antônio Baptista das Neves')
,(1,8,'Antônio Caringi')
,(1,8,'Antônio Carlos Leite')
,(1,8,'Antônio Cruz Silveira')
,(1,8,'Antônio Gonçalves de Oliveira')
,(1,8,'Antônio João')
,(1,8,'Antônio Machado Magalhães')
,(1,8,'Antônio Mendes Filho')
,(1,8,'Antônio Oliveira Rodrigues')
,(1,8,'Antônio Pereira Rodrigues')
,(1,8,'Antônio Ribeiro Cardoso')
,(1,8,'Antônio Rocha Meirelles Leite')
,(1,8,'Antônio Simão Numa')
,(1,8,'Antônio da Fonseca Moraes')
,(1,8,'Aparício Torelly')
,(1,8,'Aquidaban')
,(1,8,'Armando de Oliveira Couto Dias')
,(1,8,'Arquiteto Édison de Souza Mendonça')
,(1,8,'Artur Rocha')
,(1,8,'Augusto Duprat')
,(1,8,'Augusto Maia')
,(1,8,'Ayrton Senna')
,(1,8,'B')
,(1,8,'Bahia')
,(1,8,'Barão de Cotegipe')
,(1,8,'Barão de Santo Ângelo')
,(1,8,'Barão do Ladário')
,(1,8,'Bastos Guerra')
,(1,8,'Benjamin Constant')
,(1,8,'Bento Gonçalves')
,(1,8,'Bento Martins')
,(1,8,'Bernardo Taveira')
,(1,8,'Bolívia')
,(1,8,'Cônego Luís de Carvalho')
,(1,8,'Cônego Luiz de Carvalho')
,(1,8,'C')
,(1,8,'Caçapava')
,(1,8,'Cabo Francisco Réis')
,(1,8,'Cachoeira do Iguaçu')
,(1,8,'Caldas Júnior')
,(1,8,'Campos Sáles')
,(1,8,'Canadá')
,(1,8,'Canela')
,(1,8,'Capitão Antônio Bento dos Santos')
,(1,8,'Capitão Lemos Farias')
,(1,8,'Capitão Martiniano Francisco de Oliveira')
,(1,8,'Caramuru')
,(1,8,'Carlos Gomes')
,(1,8,'Carlos Moll')
,(1,8,'Carlos Nunes')
,(1,8,'Carlos Padilha')
,(1,8,'Carlos Vignole')
,(1,8,'Casemiro de Abreu')
,(1,8,'Castro Alves')
,(1,8,'Cento e Quarenta e Cinco')
,(1,8,'Cento e Trinta e Quatro')
,(1,8,'Cento e Vinte e Um')
,(1,8,'Chile')
,(1,8,'Cinco de Janeiro')
,(1,8,'Cinco')
,(1,8,'Coelho Neto')
,(1,8,'Colômbia')
,(1,8,'Comendador Henrique Pancada')
,(1,8,'Conde Afonso Celso')
,(1,8,'Conde de Porto Alegre')
,(1,8,'Conselheiro Teixeira Júnior')
,(1,8,'Cordilheira dos Andes')
,(1,8,'Coronel Camisão')
,(1,8,'Coronel Pedroso')
,(1,8,'Coronel Salgado')
,(1,8,'Coronel Sampaio')
,(1,8,'Costa Rica')
,(1,8,'Cristóvão Colombo')
,(1,8,'Cristóvão Jaques')
,(1,8,'Cristóvão Pereira')
,(1,8,'Cruz Alta')
,(1,8,'D')
,(1,8,'Darcy Cunha Mattos')
,(1,8,'Deputado Fernando Ferrari')
,(1,8,'Deputado Ulisses Guimarães')
,(1,8,'Dez')
,(1,8,'Dinarte Luz Alves')
,(1,8,'Dois de Novembro')
,(1,8,'Dois')
,(1,8,'Dom Bosco')
,(1,8,'Dom Manoel I')
,(1,8,'Dom Pedro I')
,(1,8,'Domingos Vanzellotti')
,(1,8,'Domingos de Almeida')
,(1,8,'Doutor Álvaro Costa')
,(1,8,'Doutor Érico Poester Peixoto')
,(1,8,'Doutor Antônio Augusto Borges de Medeiros')
,(1,8,'Doutor Círio Carlos Campani')
,(1,8,'Doutor Carlos Barbosa')
,(1,8,'Doutor Carneiro Júnior')
,(1,8,'Doutor Isnard Poester Peixoto')
,(1,8,'Doutor James Darcy')
,(1,8,'Doutor João Dias de la Rocha')
,(1,8,'Doutor Lázaro Ludovíco Zamenhof')
,(1,8,'Doutor Luís Martins Falcão')
,(1,8,'Doutor Luiz Amaro Faral')
,(1,8,'Doutor Mário Werneck')
,(1,8,'Doutor Marciano Espíndola')
,(1,8,'Doutor Napoleão Laureano')
,(1,8,'Doutor Nascimento')
,(1,8,'Doutor Nei Brito')
,(1,8,'Doutor Ney Brito')
,(1,8,'Doutor Othelo Gonçalves')
,(1,8,'Doutor Paulino de Mello Dutra')
,(1,8,'Doutor Raul Pilla')
,(1,8,'Doutor Roque Aita Júnior')
,(1,8,'Doutor Sérgio Daniel Freire')
,(1,8,'Doutor Washington Ballester de Sá Freitas')
,(1,8,'Doutora Amanda Maia')
,(1,8,'Doutora Rita Lobato')
,(1,8,'Doze')
,(1,8,'Duque de Caxias')
,(1,8,'E')
,(1,8,'Edgar Fontoura')
,(1,8,'Eduardo Araújo')
,(1,8,'Eduardo Balester')
,(1,8,'Elberto Madruga')
,(1,8,'Ema Figueiredo Costa')
,(1,8,'Engenheiro Elmer Lawsorense Corttheill')
,(1,8,'Engenheiro Heitor Amaro Barcelos')
,(1,8,'Engenheiro João Kramer de Lima')
,(1,8,'Engenheiro Jorge Ruffier')
,(1,8,'Engenheiro Luiz Arthur Ubatuba de Farias')
,(1,8,'Engenheiro Sérgio Luiz Carlos Rheingantz Pernigotti')
,(1,8,'Equador')
,(1,8,'Ernâni Fornari')
,(1,8,'Ernesto Alves')
,(1,8,'Estância Velha')
,(1,8,'Estados Unidos da América do Norte')
,(1,8,'Euríco Bianchini')
,(1,8,'Ewbank')
,(1,8,'Ex-Combatente do Brasil')
,(1,8,'F')
,(1,8,'Fausto de Oliveira Saraiva')
,(1,8,'Felipe Camarão')
,(1,8,'Fermino Amaral')
,(1,8,'Fernando Duprat da Silva')
,(1,8,'Ferroviário Antônio de Souza Netto')
,(1,8,'Firmeza')
,(1,8,'Forte Santana')
,(1,8,'Francisco Carrone')
,(1,8,'Francisco Dantolo Seta')
,(1,8,'Francisco Furtado Gomes')
,(1,8,'Francisco Marques')
,(1,8,'Francisco Pastore')
,(1,8,'Francisco Soares de Giácomo')
,(1,8,'Frederico Albuquerque')
,(1,8,'Gáspar de Lemos')
,(1,8,'G')
,(1,8,'Gamal Abdel Nasser')
,(1,8,'General Abreu')
,(1,8,'General Bacelar')
,(1,8,'General Bertoldo Klinger')
,(1,8,'General Boehm')
,(1,8,'General Câmara')
,(1,8,'General Canabarro')
,(1,8,'General Flôres da Cunha')
,(1,8,'General Neto')
,(1,8,'General Osório')
,(1,8,'General Portinho')
,(1,8,'General Vitorino')
,(1,8,'Geraldo Russomano')
,(1,8,'Gomes Freire')
,(1,8,'Gonçalo Amarante da Silva')
,(1,8,'Gonçalves Dias')
,(1,8,'Gramado')
,(1,8,'Groenlândia')
,(1,8,'Guaíba Rache')
,(1,8,'Guadalajara')
,(1,8,'Guarda Marinha Greenhalg')
,(1,8,'Guarda Marinha Lima Barreto')
,(1,8,'Guarda Oscar Jesus Nunes')
,(1,8,'Guatemala')
,(1,8,'Gustavo Sampaio')
,(1,8,'Hércio do Nascimento')
,(1,8,'Hónorato Carvalho')
,(1,8,'H')
,(1,8,'Helen Keller')
,(1,8,'Helos Guardiola Velloso')
,(1,8,'Henrique Dias')
,(1,8,'Hermínio de Morães')
,(1,8,'Herval do Sul')
,(1,8,'Honório Aikim')
,(1,8,'Honduras')
,(1,8,'I')
,(1,8,'Ildefonso Poester')
,(1,8,'Ilha Bela')
,(1,8,'Ilha da Feitoria')
,(1,8,'Ilha da Pintada')
,(1,8,'Ilha da Trindade')
,(1,8,'Ilha de Corsega')
,(1,8,'Ilha de Creta')
,(1,8,'Ilha de Humaitá')
,(1,8,'Ilha de Itaparica')
,(1,8,'Ilha de Java')
,(1,8,'Ilha de Páscoa')
,(1,8,'Ilha de Paquetá')
,(1,8,'Ilha de Rodes')
,(1,8,'Ilha do Marajó')
,(1,8,'Ilha do Pavão')
,(1,8,'Ilhas Canárias')
,(1,8,'Ilhas de Carolinas')
,(1,8,'Inspetor Azevedo')
,(1,8,'Intendente Mesquita')
,(1,8,'Intendente Werneck')
,(1,8,'Irmã Otilia')
,(1,8,'Irmão Isicio')
,(1,8,'Isidoro Franco')
,(1,8,'Israel Nisenson')
,(1,8,'J')
,(1,8,'João Alfredo')
,(1,8,'João Colins')
,(1,8,'João Fernandes Cardoso')
,(1,8,'João Juliano')
,(1,8,'João Manoel Paranhos')
,(1,8,'João Manoel')
,(1,8,'João Meirelles Leite')
,(1,8,'João Moreira')
,(1,8,'João Pedro de Pinho')
,(1,8,'João da Silva Silveira')
,(1,8,'João de Magalhães')
,(1,8,'Joaquim Gonçalves Lêdo')
,(1,8,'Jockey Clube')
,(1,8,'Jorge Gustavo Mário Schmidt')
,(1,8,'Jornalista Maurício Sirotsky Sobrinho')
,(1,8,'JornalistaArquimedes Fortini')
,(1,8,'José Diogo Chim')
,(1,8,'José Faini')
,(1,8,'José Ferreira dos Santos')
,(1,8,'José Gaspar Lourenço Péres')
,(1,8,'José Veríssimo')
,(1,8,'José da Rosa Martins')
,(1,8,'José de Alencar')
,(1,8,'Jovem Airton Pôrto Alegre')
,(1,8,'Jovem Eduardo Cunha')
,(1,8,'Juan Llopart')
,(1,8,'Juraí Xavier da Silva')
,(1,8,'L')
,(1,8,'Laguna')
,(1,8,'Lanceiros Negros')
,(1,8,'Leão XIII')
,(1,8,'Leontino Boeira')
,(1,8,'Leopoldo Fróes')
,(1,8,'Liderança')
,(1,8,'Lili Ferreira')
,(1,8,'Lino Neves')
,(1,8,'Lisboa')
,(1,8,'Luís Carlos Prestes')
,(1,8,'Luís Germano')
,(1,8,'Luis Loureiro Feio')
,(1,8,'Luiz Lorea')
,(1,8,'Mário Gomes Centro')
,(1,8,'Mário Quintas')
,(1,8,'México')
,(1,8,'M')
,(1,8,'Madame Elisa Emil Corrêa')
,(1,8,'Maestro Schmutz')
,(1,8,'Manoel Fangueiro')
,(1,8,'Manoel Francisco Moita')
,(1,8,'Manoel Gonzáles Lopes')
,(1,8,'Manoel José da Silva Bastos')
,(1,8,'Manoel Nunes Duarte')
,(1,8,'Manoel Pereira de Almeida')
,(1,8,'Manoel Vilmar Guimarães Roldão')
,(1,8,'Manoel da Ponte Jerônimo')
,(1,8,'Mar Báltico')
,(1,8,'Mar Mediterrâneo')
,(1,8,'Mar das Caraibas')
,(1,8,'Marcílio Dias')
,(1,8,'Marechal Deodoro')
,(1,8,'Marechal Eurico Gaspar Dutra')
,(1,8,'Marechal Rondon')
,(1,8,'Maria Araújo')
,(1,8,'Maria Carmem')
,(1,8,'Maria Francisca')
,(1,8,'Maria Pereira')
,(1,8,'Marinheiro João Cândido')
,(1,8,'Marino Calçada Mendonça')
,(1,8,'Marquês de Maricá')
,(1,8,'Martim Afonso de Souza')
,(1,8,'Mascarenhas de Moraes')
,(1,8,'Mateus da Costa Marques')
,(1,8,'Mendes Neto')
,(1,8,'Mestre Jerônimo')
,(1,8,'Miguel Sena')
,(1,8,'Militão Chaves')
,(1,8,'Minas Gerais')
,(1,8,'Monteiro Lobato')
,(1,8,'Moron')
,(1,8,'N')
,(1,8,'Napoleão Carlos de Azevedo')
,(1,8,'Nelo Germano')
,(1,8,'Neto Antônio')
,(1,8,'Nicarágua')
,(1,8,'Nicolau Coelho')
,(1,8,'Nicolau Copérnico')
,(1,8,'Nove')
,(1,8,'Octacílio Charão')
,(1,8,'Oito de Julho')
,(1,8,'Oito')
,(1,8,'Olavo Bilac')
,(1,8,'Onze')
,(1,8,'Osvaldo Pinto Machado')
,(1,8,'Osvaldo dos Santos Farias')
,(1,8,'Oteiro Gonçalves')
,(1,8,'Otto Anselmi')
,(1,8,'Padre Alievi')
,(1,8,'Padre Antônio Carlos Carvalho Leitão')
,(1,8,'Padre Feijó')
,(1,8,'Padre Josué Silveira de Mattos')
,(1,8,'Padre Nilo Gollo')
,(1,8,'Padre Vieira')
,(1,8,'Panamá')
,(1,8,'Panambi')
,(1,8,'Pandiá Calógeras')
,(1,8,'Paraíba')
,(1,8,'Paraguai')
,(1,8,'Paraná')
,(1,8,'Paulino Modernell')
,(1,8,'Paulo Leiria')
,(1,8,'Paulo de Frontin')
,(1,8,'Pedro Carneiro Pereira')
,(1,8,'Pedro Rocha de Andrade')
,(1,8,'Pedro de Sá Freitas')
,(1,8,'Pero Vaz de Caminha')
,(1,8,'Peru')
,(1,8,'Pinto Bandeira')
,(1,8,'Pinto da Rocha')
,(1,8,'Poeta Walter Robinson')
,(1,8,'Policial Militar Gilmar da Silva Cantos')
,(1,8,'Porto Alegre')
,(1,8,'Professor Alberto Sá')
,(1,8,'Professor Anízio Machado da Costa')
,(1,8,'Professor Anselmo Dias Lopes')
,(1,8,'Professor Antônio Gomes de Freitas')
,(1,8,'Professor Antenor Monteiro')
,(1,8,'Professor Fernando Bianchini')
,(1,8,'Professor Fernando Eduardo Freire')
,(1,8,'Professor Guillermo Enrique Dawson')
,(1,8,'Professor Henrique Farjat')
,(1,8,'Professor Mano')
,(1,8,'Professor Manoel de Souza Coelho')
,(1,8,'Professor Odenath Pereira Ferreira')
,(1,8,'Professor Picanço')
,(1,8,'Professor Rúbio Brasiliano')
,(1,8,'Professora Odete Ribeiro')
,(1,8,'Professora Suelly Costa Lopes do Valle Zogbi')
,(1,8,'Professora Vanda Rocha Martins')
,(1,8,'Quatro')
,(1,8,'Quintino Bocaiúva')
,(1,8,'Quinze')
,(1,8,'Radialista Carlos Alberto Lopes')
,(1,8,'Radialista Glênio Freitas')
,(1,8,'Rafael Anselmi')
,(1,8,'Raul Barlem')
,(1,8,'Raul Monte')
,(1,8,'República Dominicana')
,(1,8,'República de Cuba')
,(1,8,'República do Haiti')
,(1,8,'República do Líbano')
,(1,8,'República do Salvador')
,(1,8,'República')
,(1,8,'Revocata de Mello')
,(1,8,'Rio Amazonas')
,(1,8,'Rio Araguaia')
,(1,8,'Rio Capibaribe')
,(1,8,'Rio Capivari')
,(1,8,'Rio Doce')
,(1,8,'Rio Ibicuí')
,(1,8,'Rio Iguatemi')
,(1,8,'Rio Jaguari')
,(1,8,'Rio Nilo')
,(1,8,'Rio São Francisco')
,(1,8,'Rio Tietê')
,(1,8,'Rio Tocantins')
,(1,8,'Rio Xingu')
,(1,8,'Rio das Antas')
,(1,8,'Rio de Janeiro')
,(1,8,'Rodrigo Duarte')
,(1,8,'Romualdo Silva')
,(1,8,'Rosa Cruz')
,(1,8,'Rubens Corrêa')
,(1,8,'Rubens Martins')
,(1,8,'Rui Alves Pereira')
,(1,8,'Ruy Barbosa')
,(1,8,'São Domingos Sávio')
,(1,8,'São José do Norte')
,(1,8,'São Vicente de Paula')
,(1,8,'S')
,(1,8,'Sady Gaubert')
,(1,8,'Saldanha Marinho')
,(1,8,'Santa Catarina')
,(1,8,'Santa Cruz')
,(1,8,'Saturnino de Brito')
,(1,8,'Saul Porto')
,(1,8,'Secundino Félix Antunes')
,(1,8,'Seis')
,(1,8,'Senador Alberto Pasqualine')
,(1,8,'Senador Corrêa')
,(1,8,'Senador Roberto Kennedy')
,(1,8,'Senador Salgado Filho')
,(1,8,'Sete')
,(1,8,'Sindicalista Elo Wyse Rodrigues')
,(1,8,'Sir Winston Churchil')
,(1,8,'Solano Rodrigues Coimbra')
,(1,8,'Soldado Amaro')
,(1,8,'Soldado Bombeiro Antônio Silveira Azevedo')
,(1,8,'Suzana Przysylski')
,(1,8,'Taufik Abdo Nader')
,(1,8,'Teófilo Azevedo')
,(1,8,'Teixeira de Freitas')
,(1,8,'Tia Laura Barroni Canuso')
,(1,8,'Tiradentes')
,(1,8,'Tobias Barreto')
,(1,8,'Torquarto Pontes')
,(1,8,'Três de Julho')
,(1,8,'Três')
,(1,8,'Trajano Lopes')
,(1,8,'Treze')
,(1,8,'Trinta e Cinco')
,(1,8,'Trinta e Dois')
,(1,8,'Trinta e Três')
,(1,8,'Um')
,(1,8,'Umberto Ibrahim De Farias')
,(1,8,'Uruguaiana')
,(1,8,'Val Porto')
,(1,8,'Vasco da Gama')
,(1,8,'Venâncio Aires')
,(1,8,'Venezuela')
,(1,8,'Vereador Alfredo Cassahy')
,(1,8,'Vereador Arlindo Schimidt')
,(1,8,'Vereador Athaydes Rodrigues')
,(1,8,'Vereador Doutor Nilo Corrêa Fonseca')
,(1,8,'Vereador Gil dos Santos Ferreira')
,(1,8,'Vereador José Romeu')
,(1,8,'Vereador Pedro Corrêa de Azevedo')
,(1,8,'Vereador Pedro Eugênio Delinger')
,(1,8,'Vice-Almirante Abreu')
,(1,8,'Vice-Prefeito Érico Martins')
,(1,8,'Victor Canuso')
,(1,8,'Vidal de Negreiros')
,(1,8,'Vieira de Castro')
,(1,8,'Vinte e Cinco')
,(1,8,'Vinte e Dois')
,(1,8,'Vinte e Nove')
,(1,8,'Vinte e Oito')
,(1,8,'Vinte e Quatro de Maio')
,(1,8,'Vinte e Quatro')
,(1,8,'Vinte e Seis')
,(1,8,'Vinte e Sete')
,(1,8,'Vinte e Três')
,(1,8,'Vinte e Um')
,(1,8,'Vinte')
,(1,8,'Virgílio Porciuncula')
,(1,8,'Visconde de Mauá')
,(1,8,'Visconde de Paranaguá')
,(1,8,'Visconde do Rio Branco')
,(1,8,'Visconde do Rio Grande')
,(1,8,'Walter Ramos Lages')
,(1,8,'Zalony')
,(1,8,'Zumbi dos Palmares')
,(1,8,'da Gávea')
,(1,8,'da Patagônia')
,(1,8,'da Península')
,(1,8,'da Praia')
,(1,8,'da Restinga')
,(1,8,'das Âncoras')
,(1,8,'das Acácias')
,(1,8,'das Caravelas')
,(1,8,'das Cocheiras')
,(1,8,'das Dunas')
,(1,8,'das Fragatas')
,(1,8,'das Galeras')
,(1,8,'das Jangadas')
,(1,8,'das Marés')
,(1,8,'das Missões')
,(1,8,'do Aviário')
,(1,8,'do Farol')
,(1,8,'do Leme')
,(1,8,'do Mirante')
,(1,8,'do Quartel')
,(1,8,'do Riacho')
,(1,8,'dos Caçadores')
,(1,8,'dos Carijós')
,(1,8,'dos Charruas')
,(1,8,'dos Dique')
,(1,8,'dos Dragões')
,(1,8,'dos Escaleres')
,(1,8,'dos Estuários')
,(1,8,'dos Imigrantes')
,(1,8,'dos Lameiros')
,(1,8,'dos Minuanos')
,(1,8,'dos Penedos')
,(1,8,'dos Recifes')
,(1,8,'dos Saveiros')
,(1,8,'dos Tapes')
,(1,8,'dos Trópicos')
,(1,8,'dos Tupis')
,(1,9,'Assis Brasil')
,(1,9,'B')
,(1,9,'Bom Fim')
,(1,9,'Ceará')
,(1,9,'Cinco')
,(1,9,'Dez')
,(1,9,'Fluminense')
,(1,9,'Fronteira do Sul')
,(1,9,'Guianas')
,(1,9,'José Romeu (Vereador)')
,(1,9,'Pernambuco')
,(1,9,'Safira')
,(1,9,'Sergipe')
,(1,9,'Vereador José Romeu')
,(1,9,'Vitória')
,(1,9,'dos Cataventos')
;

-- Bairro iniciais
INSERT INTO bairro (cidade,nome) VALUES
 (1,'Centro')
,(1,'Aeroporto')
,(1,'América')
,(1,'Arraial')
,(1,'Atlântico Sul')
,(1,'Barra')
,(1,'Boa Vista I')
,(1,'Boa Vista II')
,(1,'Bolaxa')
,(1,'Bosque')
,(1,'Capão Seco')
,(1,'Carreiros')
,(1,'Cassino')
,(1,'Castelo Branco')
,(1,'Cibrazém')
,(1,'Cidade Nova')
,(1,'Cidade de Águeda')
,(1,'Cohab I')
,(1,'Cohab II')
,(1,'Cohab IV')
,(1,'Domingos Petroline')
,(1,'Frederico Ernesto Buchholz')
,(1,'Getúlio Vargas')
,(1,'Ilha da Torotama')
,(1,'Ilha do Leonídio')
,(1,'Ilha dos Marinheiros')
,(1,'Jardim Humaitá')
,(1,'Lagoa')
,(1,'Lar Gaúcho')
,(1,'Marluz')
,(1,'Matadouro')
,(1,'Miguel de Castro Moreira')
,(1,'Municipal')
,(1,'Palma')
,(1,'Parque Guanabara')
,(1,'Parque Marinha')
,(1,'Parque Residencial Coelho')
,(1,'Parque Residencial Jardim do Sol')
,(1,'Parque Residencial São Pedro')
,(1,'Parque Residencial Salgado Filho')
,(1,'Parque Universitário')
,(1,'Parque')
,(1,'Povo Novo')
,(1,'Profilurbi I')
,(1,'Profilurbi II')
,(1,'Querência')
,(1,'Quinta')
,(1,'Santa Rita de Cássia')
,(1,'Senandes')
,(1,'Taim')
,(1,'Vila Bernardeth')
,(1,'Vila Braz')
,(1,'Vila Dom Bosquinho')
,(1,'Vila Eulina')
,(1,'Vila Hidráulica')
,(1,'Vila Junção')
,(1,'Vila Leônidas')
,(1,'Vila Mangueira')
,(1,'Vila Maria José')
,(1,'Vila Maria dos Anjos')
,(1,'Vila Maria')
,(1,'Vila Mate Amargo')
,(1,'Vila Militar')
,(1,'Vila Nossa Senhora de Fátima')
,(1,'Vila Nossa Senhora dos Navegantes')
,(1,'Vila Recreio')
,(1,'Vila Rural')
,(1,'Vila São João')
,(1,'Vila São Jorge')
,(1,'Vila São Miguel')
,(1,'Vila Santa Rosa')
,(1,'Vila Santa Tereza')
,(1,'Zona Portuária')
;

-- Tipos de residência iniciais
INSERT INTO tipo_de_residencia (nome) VALUES
 (/*1*/'Própria financiada')
,(/*2*/'Própria quitada')
,(/*3*/'Alugada')
,(/*4*/'Emprestada')
;

-- Endereços iniciais
INSERT INTO endereco (bairro,logradouro,numero,complemento,cep,geocodigo,geom) VALUES
 (1,1,NULL,NULL,'96200-900',NULL,NULL)
;

-- Entidades iniciais
INSERT INTO entidade (tipo_de_entidade,inserido_por,endereco,nome) VALUES
 (3,1,1,'Prefeitura de Rio Grande - RS')
,(4,1,NULL,'SMS – Secretaria Municipal da Saúde')
,(4,1,NULL,'SMEd – Secretaria de Município da Educação')
,(4,1,NULL,'SMCAS – Secretaria Municipal de Cidadania e Assistência Social')
;

-- Usuários iniciais
INSERT INTO usuario VALUES
 (1,'$2y$10$njoj7zQeS8BXvG8frzdWfO5NLn7MY1znSZirL5fJWrEoZigxdigsu')
,(2,'$2y$10$rZvnSR6zFEQWla9kTnys6u5mGqUUWYsdYeu79jPdIqwd4xcJNuYsu')
,(3,'$2y$10$t7lYttCfZBeJvPeHrrjPRur2uJTckRoEb5C45hfG9uwn7OqfFJbMG')
,(4,'$2y$10$a9h2Y6BQNw7vxNgTEeylWOg6oxR8H48CF6Av1dumUdcUMQxrDN0jW')
;

-- Vínculos pessoais iniciais
INSERT INTO vinculo_pessoal (nome) VALUES
 ('Pai/Mãe')
,('Avô/Avó')
,('Tio/Tia')
,('Irmão/Irmã')
,('Primo/Prima')
,('Cuidador/Cuidadora')
,('Monitor/Monitora')
;

-- Medicação
INSERT INTO medicacao (nome) VALUES
 ('Agentes colinérgicos')
,('Amebicida e tricomonicida')
,('Aminoglicosídeos')
,('Analgésicos')
,('Anti-helmínticos')
,('Anti-hipertensivos')
,('Anti-histamínicos')
,('Anti-inflamatórios')
,('Antiarritmicos')
,('Anticoagulantes')
,('Anticonvulsivantes')
,('Antidepressivos')
,('Antifúngicos')
,('Antimaláricos')
,('Antineoplásicos')
,('Antiparkinsonianos')
,('Antivirais')
,('Barbitúricos')
,('Benzodiazepínicos')
,('Bloqueadores alfa-adrenérgico')
,('Bloqueadores beta-adrenérgico')
,('Bloqueadores dos canais de cálcio')
,('Broncodilatadores')
,('Cardiotônicos')
,('Cefalosporina')
,('Corticoides')
,('Diuréticos')
,('Hipoglicêmicos')
,('Inibidor de colinesterase')
,('Insulina')
,('Narcóticos')
,('Penicilina')
,('Sedativos')
,('Sulfonamida')
,('Teofilina')
,('Tetraciclina')
,('Vagotônico')
,('Vasodilatador coronariano')
;

-- Tipos de serviço iniciais
INSERT INTO tipo_de_servico (nome) VALUES
 (/*1*/'Assistência Social')
,(/*2*/'Defesa dos Direitos das Pessoas com Deficiência')
,(/*3*/'Educação')
,(/*4*/'Habitação')
,(/*5*/'Mobilidade')
,(/*6*/'Saúde')
;

-- Serviços
INSERT INTO servico (tipo_de_servico,nome) VALUES
 (/*01*/1,'Aposentadoria para pessoas de baixa renda')
,(/*02*/1,'Banco do Vestuário')
,(/*03*/1,'CRAS')
,(/*04*/1,'CREAS')
,(/*05*/1,'Cadastro Único')
,(/*06*/1,'Carteira do Idoso')
,(/*07*/1,'Castração de animais')
,(/*08*/1,'Construa a casa no seu terreno')
,(/*09*/1,'Criança feliz')
,(/*10*/1,'Identidade Jovem (ID Jovem)')
,(/*11*/1,'Inclusão Produtiva')
,(/*12*/1,'Isenção de Pagamento de Taxa de Inscrição em Concursos Públicos')
,(/*13*/1,'Isenção de Pagamento de Taxa no ENEM')
,(/*14*/1,'Programa de Erradicação do Trabalho Infantil')
,(/*15*/1,'Tarifa Social da água')
,(/*16*/1,'Tarifa social de energia Elétrica')
,(/*17*/1,'Telefone Popular')
,(/*18*/2,'Conselho Tutelar')
,(/*19*/2,'Conselho de Direitos das Pessoas com Deficiência')
,(/*20*/2,'Defensoria Pública')
,(/*21*/2,'Fóruns')
,(/*22*/2,'Ministério Público')
,(/*23*/3,'Monitor (aguardando)')
,(/*24*/3,'Monitor')
,(/*25*/3,'Psicopedagogia privado')
,(/*26*/3,'Psicopedagogia')
,(/*27*/3,'Sala de Recursos Multifuncionais')
,(/*28*/4,'Minha Casa Minha Vida (aguardando)')
,(/*29*/4,'Minha Casa Minha Vida')
,(/*30*/5,'Passe livre')
,(/*31*/6,'CAPS - Assistente Social')
,(/*32*/6,'CAPS - Psicólogo')
,(/*33*/6,'CAPS - Psiquiatra')
,(/*34*/6,'CAPSI - Arte Educador')
,(/*35*/6,'CAPSI - Assistente Social')
,(/*36*/6,'CAPSI - Fonoaudiólogo')
,(/*37*/6,'CAPSI - Psicólogo')
,(/*38*/6,'CAPSI - Psicopedagogo')
,(/*39*/6,'CAPSI - Psiquiatra')
,(/*40*/6,'Farmácia Municipal')
,(/*41*/6,'Fisioterapia público (aguardando)')
,(/*42*/6,'Fisioterapia público')
,(/*43*/6,'Fisioterapia privado')
,(/*44*/6,'Fonoaudiólogo público')
,(/*45*/6,'Fonoaudiólogo privado')
,(/*46*/6,'Medicação do SUS')
,(/*47*/6,'Neurologista público')
,(/*48*/6,'Neurologista privado')
,(/*49*/6,'Odontologia público')
,(/*50*/6,'Primeira infância melhor')
,(/*51*/6,'Programa de alimentação e nutrição')
,(/*52*/6,'Programa de atenção à saúde da população negra')
,(/*53*/6,'Programa de atenção à saúde de lésbicas, gays, bissexuais, travestis, transexuais e intersexuais')
,(/*54*/6,'Programa de atenção à saúde do homem')
,(/*55*/6,'Programa de atenção à saúde do idoso')
,(/*56*/6,'Programa de atenção à saúde do indígena')
,(/*57*/6,'Programa de atenção integral à saúde da criança')
,(/*58*/6,'Programa de atenção integral à saúde da mulher')
,(/*59*/6,'Programa de atenção integral à saúde do adolescente')
,(/*60*/6,'Programa de combate ao tabagismo')
,(/*61*/6,'Programa de controle de tuberculose')
,(/*62*/6,'Programa de fisioterapia e programa de atenção integral à saúde da pessoa com deficiência')
,(/*63*/6,'Programa municipal IST/AIDS e hepatites virais')
,(/*64*/6,'Programa saúde na escola')
,(/*65*/6,'Projeto vida ativa')
,(/*66*/6,'Psicólogo público')
,(/*67*/6,'Psicólogo privado')
,(/*68*/6,'Psiquiatra público')
,(/*69*/6,'Psiquiatra privado')
,(/*70*/6,'Reabilitação público (aguardando)')
,(/*71*/6,'Reabilitação público')
;

-- Seções de histórico iniciais
INSERT INTO secao_de_historico (nome) VALUES
 (/*1*/'Saúde')
,(/*2*/'Educação')
,(/*3*/'Assistência Social')
,(/*4*/'Trabalho')
,(/*5*/'Habitação')
,(/*6*/'Mobilidade Urbana')
;

-- Ações iniciais
INSERT INTO acao (nome,tem_objeto) VALUES
 (/*001*/'Adicionar gêneros',FALSE)
,(/*002*/'Alterar o gênero',TRUE)
,(/*003*/'Excluir o gênero',TRUE)
,(/*004*/'Adicionar estados civis',FALSE)
,(/*005*/'Alterar o estado civil',TRUE)
,(/*006*/'Excluir o estado civil',TRUE)
,(/*007*/'Adicionar diagnósticos',FALSE)
,(/*008*/'Alterar o diagnóstico',TRUE)
,(/*009*/'Excluir o diagnóstico',TRUE)
,(/*010*/'Adicionar status de diagnóstico',FALSE)
,(/*011*/'Alterar o status de diagnóstico',TRUE)
,(/*012*/'Excluir o status de diagnóstico',TRUE)
,(/*013*/'Adicionar escolaridades',FALSE)
,(/*014*/'Alterar a escolaridade',TRUE)
,(/*015*/'Excluir a escolaridade',TRUE)
,(/*016*/'Adicionar séries escolares',FALSE)
,(/*017*/'Alterar a série escolar',TRUE)
,(/*018*/'Excluir a série escolar',TRUE)
,(/*019*/'Adicionar turnos escolares',FALSE)
,(/*020*/'Alterar o turno escolar',TRUE)
,(/*021*/'Excluir o turno escolar',TRUE)
,(/*022*/'Adicionar raças',FALSE)
,(/*023*/'Alterar a raça',TRUE)
,(/*024*/'Excluir a raça',TRUE)
,(/*025*/'Adicionar benefícios',FALSE)
,(/*026*/'Alterar o benefício',TRUE)
,(/*027*/'Excluir o benefício',TRUE)
,(/*028*/'Adicionar barreiras',FALSE)
,(/*029*/'Alterar a barreira',TRUE)
,(/*030*/'Excluir a barreira',TRUE)
,(/*031*/'Adicionar países',FALSE)
,(/*032*/'Alterar o país',TRUE)
,(/*033*/'Excluir o país',TRUE)
,(/*034*/'Adicionar unidades federativas ao país',TRUE)
,(/*035*/'Alterar a unidade federativa',TRUE)
,(/*036*/'Excluir a unidade federativa',TRUE)
,(/*037*/'Adicionar cidades à unidade federativa',TRUE)
,(/*038*/'Alterar a cidade',TRUE)
,(/*039*/'Excluir a cidade',TRUE)
,(/*040*/'Adicionar tipos de logradouro',FALSE)
,(/*041*/'Alterar o tipo de logradouro',TRUE)
,(/*042*/'Excluir o tipo de logradouro',TRUE)
,(/*043*/'Adicionar logradouros à cidade',TRUE)
,(/*044*/'Alterar o logradouro',TRUE)
,(/*045*/'Excluir o logradouro',TRUE)
,(/*046*/'Adicionar bairros à cidade',TRUE)
,(/*047*/'Alterar o bairro',TRUE)
,(/*048*/'Excluir o bairro',TRUE)
,(/*049*/'Adicionar endereços',FALSE)
,(/*050*/'Alterar o endereço',TRUE)
,(/*051*/'Excluir o endereço',TRUE)
,(/*052*/'Adicionar tipos de entidade',FALSE)
,(/*053*/'Alterar o tipo de entidade',TRUE)
,(/*054*/'Excluir o tipo de entidade',TRUE)
,(/*055*/'Adicionar entidades do tipo',TRUE)
,(/*056*/'Alterar a entidade',TRUE)
,(/*057*/'Excluir a entidade',TRUE)
,(/*058*/'Tornar usuário a entidade',TRUE)
,(/*059*/'Alterar a senha do usuário',TRUE)
,(/*060*/'Excluir o usuário',TRUE)
,(/*061*/'Adicionar vínculos pessoais',FALSE)
,(/*062*/'Alterar o vínculo pessoal',TRUE)
,(/*063*/'Excluir o vínculo pessoal',TRUE)
,(/*064*/'Adicionar profissões',FALSE)
,(/*065*/'Alterar a profissão',TRUE)
,(/*066*/'Excluir a profissão',TRUE)
,(/*067*/'Adicionar serviços de assistência social',FALSE)
,(/*068*/'Alterar o serviço de assistência social',TRUE)
,(/*069*/'Excluir o serviço de assistência social',TRUE)
,(/*070*/'Adicionar serviços de defesa dos direitos das pessoas com deficiência',FALSE)
,(/*071*/'Alterar o serviço de defesa dos direitos das pessoas com deficiência',TRUE)
,(/*072*/'Excluir o serviço de defesa dos direitos das pessoas com deficiência',TRUE)
,(/*073*/'Exibir dados sobre saúde da pessoa física',TRUE)
,(/*074*/'Manipular dados sobre saúde da pessoa física',TRUE)
,(/*075*/'Exibir dados sobre educação da pessoa física',TRUE)
,(/*076*/'Manipular dados sobre educação da pessoa física',TRUE)
,(/*077*/'Exibir dados sobre assistência social da pessoa física',TRUE)
,(/*078*/'Manipular dados sobre assistência social da pessoa física',TRUE)
,(/*079*/'Exibir dados sobre trabalho da pessoa física',TRUE)
,(/*080*/'Manipular dados sobre trabalho da pessoa física',TRUE)
,(/*081*/'Exibir dados sobre vínculos da pessoa física',TRUE)
,(/*082*/'Manipular dados sobre vínculos da pessoa física',TRUE)
,(/*083*/'Exibir dados sobre histórico da pessoa física',TRUE)
,(/*084*/'Incluir dados sobre histórico da pessoa física',TRUE)
,(/*085*/'Excluir dados sobre histórico da pessoa física',TRUE)
,(/*086*/'Excluir dados sobre histórico postado pela entidade',TRUE)
,(/*087*/'Exibir e manipular permissões',FALSE)
,(/*088*/'Adicionar tecnologia',FALSE)
,(/*089*/'Alterar a tecnologia',TRUE)
,(/*090*/'Excluir a tecnologia',TRUE)
,(/*091*/'Adicionar medicação',FALSE)
,(/*092*/'Alterar a medicação',TRUE)
,(/*093*/'Excluir a medicação',TRUE)
,(/*094*/'Adicionar serviços de saúde',FALSE)
,(/*095*/'Alterar o serviço de saúde',TRUE)
,(/*096*/'Excluir o serviço de saúde',TRUE)
,(/*097*/'Adicionar serviços de educação',FALSE)
,(/*098*/'Alterar o serviço de educação',TRUE)
,(/*099*/'Excluir o serviço de educação',TRUE)
,(/*100*/'Adicionar serviços de mobilidade urbana',FALSE)
,(/*101*/'Alterar o serviço de mobilidade urbana',TRUE)
,(/*102*/'Excluir o serviço de mobilidade urbana',TRUE)
,(/*103*/'Exibir dados sobre mobilidade urbana da pessoa física',TRUE)
,(/*104*/'Manipular dados sobre mobilidade urbana da pessoa física',TRUE)
,(/*105*/'Exibir dados sobre habitação da pessoa física',TRUE)
,(/*106*/'Manipular dados sobre habitação da pessoa física',TRUE)
,(/*107*/'Adicionar tipos de residência',FALSE)
,(/*108*/'Alterar o tipo de residência',TRUE)
,(/*109*/'Excluir o tipo de residência',TRUE)
,(/*110*/'Adicionar adaptações arquitetônicas',FALSE)
,(/*111*/'Alterar a adaptação arquitetônica',TRUE)
,(/*112*/'Excluir a adaptação arquitetônica',TRUE)
,(/*113*/'Adicionar serviços de habitação',FALSE)
,(/*114*/'Alterar o serviço de habitação',TRUE)
,(/*115*/'Excluir o serviço de habitação',TRUE)
,(/*116*/'Adicionar serviços do tipo',TRUE)
,(/*117*/'Alterar o serviço',TRUE)
,(/*118*/'Excluir o serviço',TRUE)
;

-- Dados de permissões sobre o DB
-- Quem pode ou não executar determinada ação sobre determinada coisa no DB
-- NULL indica qualquer sujeito ou objeto

INSERT INTO permissao_e_genero VALUES
 (NULL,TRUE,1,NULL)
,(NULL,FALSE,2,NULL)
,(1,TRUE,2,NULL)
,(NULL,FALSE,3,NULL)
,(1,TRUE,3,NULL)
;

INSERT INTO permissao_e_estado_civil VALUES
 (NULL,TRUE,4,NULL)
,(NULL,FALSE,5,NULL)
,(1,TRUE,5,NULL)
,(NULL,FALSE,6,NULL)
,(1,TRUE,6,NULL)
;

INSERT INTO permissao_e_diagnostico VALUES
 (NULL,TRUE,7,NULL)
,(NULL,FALSE,8,NULL)
,(1,TRUE,8,NULL)
,(2,TRUE,8,NULL)
,(NULL,FALSE,9,NULL)
,(1,TRUE,9,NULL)
,(2,TRUE,9,NULL)
;

INSERT INTO permissao_e_status_de_diagnostico VALUES
 (NULL,FALSE,10,NULL)
,(NULL,FALSE,11,NULL)
,(NULL,FALSE,12,NULL)
;

INSERT INTO permissao_e_escolaridade VALUES
 (NULL,FALSE,13,NULL)
,(1,TRUE,13,NULL)
,(3,TRUE,13,NULL)
,(NULL,FALSE,14,NULL)
,(1,TRUE,14,NULL)
,(3,TRUE,14,NULL)
,(NULL,FALSE,15,NULL)
,(1,TRUE,15,NULL)
,(3,TRUE,15,NULL)
;

INSERT INTO permissao_e_serie_escolar VALUES
 (NULL,FALSE,16,NULL)
,(1,TRUE,16,NULL)
,(3,TRUE,16,NULL)
,(NULL,FALSE,17,NULL)
,(1,TRUE,17,NULL)
,(3,TRUE,17,NULL)
,(NULL,FALSE,18,NULL)
,(1,TRUE,18,NULL)
,(3,TRUE,18,NULL)
;

INSERT INTO permissao_e_turno_escolar VALUES
 (NULL,FALSE,19,NULL)
,(NULL,FALSE,20,NULL)
,(NULL,FALSE,21,NULL)
;

INSERT INTO permissao_e_raca VALUES
 (NULL,TRUE,22,NULL)
,(NULL,FALSE,23,NULL)
,(1,TRUE,23,NULL)
,(NULL,FALSE,24,NULL)
,(1,TRUE,24,NULL)
;

INSERT INTO permissao_e_beneficio VALUES
 (NULL,FALSE,25,NULL)
,(1,TRUE,25,NULL)
,(4,TRUE,25,NULL)
,(NULL,FALSE,26,NULL)
,(1,TRUE,26,NULL)
,(4,TRUE,26,NULL)
,(NULL,FALSE,27,NULL)
,(1,TRUE,27,NULL)
,(4,TRUE,27,NULL)
;

INSERT INTO permissao_e_tecnologia VALUES
 (NULL,FALSE,88,NULL)
,(1,TRUE,88,NULL)
,(NULL,FALSE,89,NULL)
,(1,TRUE,89,NULL)
,(NULL,FALSE,90,NULL)
,(1,TRUE,90,NULL)
;

INSERT INTO permissao_e_barreira VALUES
 (NULL,TRUE,28,NULL)
,(NULL,FALSE,29,NULL)
,(1,TRUE,29,NULL)
,(NULL,FALSE,30,NULL)
,(1,TRUE,30,NULL)
;

INSERT INTO permissao_e_adaptacao_arquitetonica VALUES
 (NULL,FALSE,110,NULL)
,(1,TRUE,110,NULL)
,(NULL,FALSE,111,NULL)
,(1,TRUE,111,NULL)
,(NULL,FALSE,112,NULL)
,(1,TRUE,112,NULL)
;

INSERT INTO permissao_e_pais VALUES
 (NULL,TRUE,31,NULL)
,(NULL,FALSE,32,NULL)
,(1,TRUE,32,NULL)
,(NULL,FALSE,33,NULL)
,(1,TRUE,33,NULL)
,(NULL,TRUE,34,NULL)
,(NULL,FALSE,34,1)
;

INSERT INTO permissao_e_uf VALUES
 (NULL,TRUE,35,NULL)
,(NULL,FALSE,35,1)
,(NULL,FALSE,35,2)
,(NULL,FALSE,35,3)
,(NULL,FALSE,35,4)
,(NULL,FALSE,35,5)
,(NULL,FALSE,35,6)
,(NULL,FALSE,35,7)
,(NULL,FALSE,35,8)
,(NULL,FALSE,35,9)
,(NULL,FALSE,35,10)
,(NULL,FALSE,35,11)
,(NULL,FALSE,35,12)
,(NULL,FALSE,35,13)
,(NULL,FALSE,35,14)
,(NULL,FALSE,35,15)
,(NULL,FALSE,35,16)
,(NULL,FALSE,35,17)
,(NULL,FALSE,35,18)
,(NULL,FALSE,35,19)
,(NULL,FALSE,35,20)
,(NULL,FALSE,35,21)
,(NULL,FALSE,35,22)
,(NULL,FALSE,35,23)
,(NULL,FALSE,35,24)
,(NULL,FALSE,35,25)
,(NULL,FALSE,35,26)
,(NULL,FALSE,35,27)
,(NULL,TRUE,36,NULL)
,(NULL,FALSE,36,1)
,(NULL,FALSE,36,2)
,(NULL,FALSE,36,3)
,(NULL,FALSE,36,4)
,(NULL,FALSE,36,5)
,(NULL,FALSE,36,6)
,(NULL,FALSE,36,7)
,(NULL,FALSE,36,8)
,(NULL,FALSE,36,9)
,(NULL,FALSE,36,10)
,(NULL,FALSE,36,11)
,(NULL,FALSE,36,12)
,(NULL,FALSE,36,13)
,(NULL,FALSE,36,14)
,(NULL,FALSE,36,15)
,(NULL,FALSE,36,16)
,(NULL,FALSE,36,17)
,(NULL,FALSE,36,18)
,(NULL,FALSE,36,19)
,(NULL,FALSE,36,20)
,(NULL,FALSE,36,21)
,(NULL,FALSE,36,22)
,(NULL,FALSE,36,23)
,(NULL,FALSE,36,24)
,(NULL,FALSE,36,25)
,(NULL,FALSE,36,26)
,(NULL,FALSE,36,27)
,(NULL,TRUE,37,NULL)
;

INSERT INTO permissao_e_cidade VALUES
 (NULL,FALSE,38,NULL)
,(NULL,FALSE,39,NULL)
,(NULL,TRUE,43,NULL)
,(NULL,TRUE,46,NULL)
;

INSERT INTO permissao_e_tipo_de_logradouro VALUES
 (NULL,FALSE,40,NULL)
,(NULL,FALSE,41,NULL)
,(NULL,FALSE,42,NULL)
;

INSERT INTO permissao_e_logradouro VALUES
 (NULL,FALSE,44,NULL)
,(1,TRUE,44,NULL)
,(NULL,FALSE,45,NULL)
,(1,TRUE,45,NULL)
;

INSERT INTO permissao_e_bairro VALUES
 (NULL,FALSE,47,NULL)
,(1,TRUE,47,NULL)
,(NULL,FALSE,48,NULL)
,(1,TRUE,48,NULL)
;

INSERT INTO permissao_e_tipo_de_residencia VALUES
 (NULL,FALSE,107,NULL)
,(1,TRUE,107,NULL)
,(NULL,FALSE,108,NULL)
,(1,TRUE,108,NULL)
,(NULL,FALSE,109,NULL)
,(1,TRUE,109,NULL)
;

INSERT INTO permissao_e_endereco VALUES
 (NULL,TRUE,49,NULL)
,(NULL,TRUE,50,NULL)
,(NULL,TRUE,51,NULL)
,(NULL,FALSE,50,1)
,(NULL,FALSE,51,1)
,(1,TRUE,50,1)
,(1,TRUE,51,1)
;

INSERT INTO permissao_e_tipo_de_entidade VALUES
 (NULL,FALSE,52,NULL)
,(NULL,FALSE,53,NULL)
,(NULL,FALSE,54,NULL)
,(NULL,FALSE,55,NULL)
,(NULL,TRUE,55,1)
,(NULL,TRUE,55,2)
,(1,TRUE,55,NULL)
,(2,TRUE,55,10)
,(3,TRUE,55,5)
,(3,TRUE,55,6)
,(3,TRUE,55,7)
,(3,TRUE,55,8)
,(3,TRUE,55,9)
,(4,TRUE,55,11)
,(4,TRUE,55,12)
;

INSERT INTO permissao_e_vinculo_pessoal VALUES
 (NULL,FALSE,61,NULL)
,(NULL,FALSE,62,NULL)
,(NULL,FALSE,63,NULL)
;

INSERT INTO permissao_e_profissao VALUES
 (NULL,TRUE,64,NULL)
,(NULL,FALSE,65,NULL)
,(1,TRUE,65,NULL)
,(NULL,FALSE,66,NULL)
,(1,TRUE,66,NULL)
;

INSERT INTO permissao_e_medicacao VALUES
 (NULL,TRUE,91,NULL)
,(NULL,FALSE,92,NULL)
,(2,TRUE,92,NULL)
,(NULL,FALSE,93,NULL)
,(2,TRUE,93,NULL)
;

INSERT INTO permissao_e_tipo_de_servico VALUES
 (NULL,FALSE,116,NULL)
,(1,TRUE,116,NULL)
,(2,TRUE,116,6)
,(3,TRUE,116,3)
,(4,TRUE,116,1)
,(4,TRUE,116,2)
;

INSERT INTO permissao_e_servico VALUES
 (NULL,FALSE,117,NULL)
,(NULL,FALSE,118,NULL)
,(1,TRUE,117,NULL),(1,TRUE,118,NULL)
,(2,TRUE,117,31),(2,TRUE,118,31)
,(2,TRUE,117,32),(2,TRUE,118,32)
,(2,TRUE,117,33),(2,TRUE,118,33)
,(2,TRUE,117,34),(2,TRUE,118,34)
,(2,TRUE,117,35),(2,TRUE,118,35)
,(2,TRUE,117,36),(2,TRUE,118,36)
,(2,TRUE,117,37),(2,TRUE,118,37)
,(2,TRUE,117,38),(2,TRUE,118,38)
,(2,TRUE,117,39),(2,TRUE,118,39)
,(2,TRUE,117,40),(2,TRUE,118,40)
,(2,TRUE,117,41),(2,TRUE,118,41)
,(2,TRUE,117,42),(2,TRUE,118,42)
,(2,TRUE,117,43),(2,TRUE,118,43)
,(2,TRUE,117,44),(2,TRUE,118,44)
,(2,TRUE,117,45),(2,TRUE,118,45)
,(2,TRUE,117,46),(2,TRUE,118,46)
,(2,TRUE,117,47),(2,TRUE,118,47)
,(2,TRUE,117,48),(2,TRUE,118,48)
,(2,TRUE,117,49),(2,TRUE,118,49)
,(2,TRUE,117,50),(2,TRUE,118,50)
,(2,TRUE,117,51),(2,TRUE,118,51)
,(2,TRUE,117,52),(2,TRUE,118,52)
,(2,TRUE,117,53),(2,TRUE,118,53)
,(2,TRUE,117,54),(2,TRUE,118,54)
,(2,TRUE,117,55),(2,TRUE,118,55)
,(2,TRUE,117,56),(2,TRUE,118,56)
,(2,TRUE,117,57),(2,TRUE,118,57)
,(2,TRUE,117,58),(2,TRUE,118,58)
,(2,TRUE,117,59),(2,TRUE,118,59)
,(2,TRUE,117,60),(2,TRUE,118,60)
,(2,TRUE,117,61),(2,TRUE,118,61)
,(2,TRUE,117,62),(2,TRUE,118,62)
,(2,TRUE,117,63),(2,TRUE,118,63)
,(2,TRUE,117,64),(2,TRUE,118,64)
,(2,TRUE,117,65),(2,TRUE,118,65)
,(2,TRUE,117,66),(2,TRUE,118,66)
,(2,TRUE,117,67),(2,TRUE,118,67)
,(2,TRUE,117,68),(2,TRUE,118,68)
,(2,TRUE,117,69),(2,TRUE,118,69)
,(2,TRUE,117,70),(2,TRUE,118,70)
,(2,TRUE,117,71),(2,TRUE,118,71)
,(3,TRUE,117,23),(3,TRUE,118,23)
,(3,TRUE,117,24),(3,TRUE,118,24)
,(3,TRUE,117,25),(3,TRUE,118,25)
,(3,TRUE,117,26),(3,TRUE,118,26)
,(3,TRUE,117,27),(3,TRUE,118,27)
,(4,TRUE,117,1),(4,TRUE,118,1)
,(4,TRUE,117,2),(4,TRUE,118,2)
,(4,TRUE,117,3),(4,TRUE,118,3)
,(4,TRUE,117,4),(4,TRUE,118,4)
,(4,TRUE,117,5),(4,TRUE,118,5)
,(4,TRUE,117,6),(4,TRUE,118,6)
,(4,TRUE,117,7),(4,TRUE,118,7)
,(4,TRUE,117,8),(4,TRUE,118,8)
,(4,TRUE,117,9),(4,TRUE,118,9)
,(4,TRUE,117,10),(4,TRUE,118,10)
,(4,TRUE,117,11),(4,TRUE,118,11)
,(4,TRUE,117,12),(4,TRUE,118,12)
,(4,TRUE,117,13),(4,TRUE,118,13)
,(4,TRUE,117,14),(4,TRUE,118,14)
,(4,TRUE,117,15),(4,TRUE,118,15)
,(4,TRUE,117,16),(4,TRUE,118,16)
,(4,TRUE,117,17),(4,TRUE,118,17)
,(4,TRUE,117,18),(4,TRUE,118,18)
,(4,TRUE,117,19),(4,TRUE,118,19)
,(4,TRUE,117,20),(4,TRUE,118,20)
,(4,TRUE,117,21),(4,TRUE,118,21)
,(4,TRUE,117,22),(4,TRUE,118,22)
;

INSERT INTO permissao_e_servico_de_saude VALUES
 (NULL,TRUE,94,NULL)
,(NULL,FALSE,95,NULL)
,(1,TRUE,95,NULL)
,(2,TRUE,95,NULL)
,(NULL,FALSE,96,NULL)
,(1,TRUE,96,NULL)
,(2,TRUE,96,NULL)
;

INSERT INTO permissao_e_servico_de_educacao VALUES
 (NULL,TRUE,97,NULL)
,(NULL,FALSE,98,NULL)
,(1,TRUE,98,NULL)
,(3,TRUE,98,NULL)
,(NULL,FALSE,99,NULL)
,(1,TRUE,99,NULL)
,(3,TRUE,99,NULL)
;

INSERT INTO permissao_e_servico_de_as VALUES
 (NULL,TRUE,67,NULL)
,(NULL,FALSE,68,NULL)
,(1,TRUE,68,NULL)
,(4,TRUE,68,NULL)
,(NULL,FALSE,69,NULL)
,(1,TRUE,69,NULL)
,(4,TRUE,69,NULL)
;

INSERT INTO permissao_e_servico_de_ddpd VALUES
 (NULL,TRUE,70,NULL)
,(NULL,FALSE,71,NULL)
,(1,TRUE,71,NULL)
,(NULL,FALSE,72,NULL)
,(1,TRUE,72,NULL)
;

INSERT INTO permissao_e_servico_de_mob VALUES
 (NULL,TRUE,100,NULL)
,(NULL,FALSE,101,NULL)
,(1,TRUE,101,NULL)
,(NULL,FALSE,102,NULL)
,(1,TRUE,102,NULL)
;

INSERT INTO permissao_e_servico_de_hab VALUES
 (NULL,TRUE,113,NULL)
,(NULL,FALSE,114,NULL)
,(1,TRUE,114,NULL)
,(NULL,FALSE,115,NULL)
,(1,TRUE,115,NULL)
;

INSERT INTO permissao_e_entidade VALUES
 (NULL,TRUE,56,NULL)
,(NULL,FALSE,56,1)
,(NULL,FALSE,56,2)
,(NULL,FALSE,56,3)
,(NULL,FALSE,56,4)
,(1,TRUE,56,1)
,(2,TRUE,56,2)
,(3,TRUE,56,3)
,(4,TRUE,56,4)
,(NULL,TRUE,57,NULL)
,(NULL,FALSE,57,1)
,(NULL,FALSE,57,2)
,(NULL,FALSE,57,3)
,(NULL,FALSE,57,4)
,(NULL,FALSE,58,NULL)
,(1,TRUE,58,NULL)
,(NULL,FALSE,59,NULL)
,(1,TRUE,59,NULL)
,(1,TRUE,59,1)
,(2,TRUE,59,2)
,(3,TRUE,59,3)
,(4,TRUE,59,4)
,(NULL,FALSE,60,NULL)
,(1,TRUE,60,NULL)
,(1,TRUE,60,1)
,(2,TRUE,60,2)
,(3,TRUE,60,3)
,(4,TRUE,60,4)
,(NULL,TRUE,73,NULL)
,(NULL,FALSE,74,NULL)
,(1,TRUE,74,NULL)
,(2,TRUE,74,NULL)
,(NULL,TRUE,75,NULL)
,(NULL,FALSE,76,NULL)
,(1,TRUE,76,NULL)
,(3,TRUE,76,NULL)
,(NULL,TRUE,77,NULL)
,(NULL,FALSE,78,NULL)
,(1,TRUE,78,NULL)
,(4,TRUE,78,NULL)
,(NULL,TRUE,79,NULL)
,(NULL,TRUE,80,NULL)
,(NULL,TRUE,81,NULL)
,(NULL,TRUE,82,NULL)
,(NULL,TRUE,83,NULL)
,(NULL,TRUE,84,NULL)
,(NULL,TRUE,85,NULL)
,(NULL,TRUE,86,NULL)
,(NULL,FALSE,86,1)
,(NULL,FALSE,86,2)
,(NULL,FALSE,86,3)
,(NULL,FALSE,86,4)
,(1,TRUE,86,1)
,(2,TRUE,86,2)
,(3,TRUE,86,3)
,(4,TRUE,86,4)
,(1,TRUE,86,NULL)
,(NULL,FALSE,87,NULL)
,(1,TRUE,87,NULL)
,(NULL,TRUE,103,NULL)
,(NULL,FALSE,104,NULL)
,(1,TRUE,104,NULL)
,(NULL,TRUE,105,NULL)
,(NULL,FALSE,106,NULL)
,(1,TRUE,106,NULL)
;

-- Dados para teste. Excluir em produção
INSERT INTO entidade (tipo_de_entidade,inserido_por,endereco,nome) VALUES
 (1,1,NULL,'Fulano de Tal')
,(5,3,NULL,'E.M.E.F. A')
,(6,3,NULL,'E.E.E.M. B')
,(11,4,NULL,'CRAS A')
,(11,4,NULL,'CRAS B')
,(11,4,NULL,'CRAS C')
,(12,4,NULL,'CREAS A')
;

INSERT INTO pessoa_fisica (id) VALUES (5);
