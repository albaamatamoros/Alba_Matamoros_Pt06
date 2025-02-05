<!-- Alba Matamoros Morales -->
# Pràctica 06 - APIRest, Ajax i codis QR
Si vols fer proves amb usuaris ja creats tots tenen el pasword = P@ssw0rd

ddb237716.sql (Alba Matamoros bd)

Modificació al php.ini XAMP ->
Descomentar la linea "extension=gd".

# Taula d'usuaris i contrasenyes

| **Usuari**      | **Rol**      | **Contrasenya**  |
|------------------|--------------|------------------|
| ppan            | Admin       | P@ssw0rd         |
| mjane           | Usuari       | P@ssw0rd         |
| amatamoros      | Admin       | P@ssw0rd         |
| nouusuari1      | Usuari       | P@ssw0rd         |
| nouusuari2      | Usuari       | P@ssw0rd         |

La temàtica de la meva pàgina és "Personatges de One piece", els usuaris han d'introduir tots els personatges existents actualment, cada usuari fa la seva aportació sense repetir el personatge inserit per altra persona.

## Descripció del Projecte

Aquest projecte és una aplicació web que permet als usuaris autenticar-se utilitzant diferents mètodes socials i afegir personatges de la sèrie "One Piece". Cada usuari pot contribuir amb personatges, assegurant-se que no es repeteixin.

## Estructura
- **`controlador`**
  - `Api`
    - `controladorOnePiece.php`
  - `HybridAuthC`
    - `callbackReddit.php`
  - `OAuth`
    - `callbackGoogle.php`
  - `controladorAdministrarPerfil.php`
  - `controladorCopiarPersonatge.php`
  - `controladorErrors.php`
  - `controladorEsborrar.php`
  - `controladorInsertar.php`
  - `controladorLectorQR.php`
  - `controladorLogin.php`
  - `controladorModificar.php`
  - `controladorModificarDades.php`
  - `controladorPaginacio.php`
  - `controladorRegistrar.php`
  - `controladorTancarSessio.php`
- **`estils`**
    - `errors.css`
    - `general.css`
    - `menu.css`
    - `modal.css`
    - `mostrar.css`
    - `paginacio.css`
    - `perfil.css`
    - `proves.css`
- **`lib`**
    - `chillerlan`
    - `HybridAuth`
        - `configReddit.php`
    - `OAuth`
        - `configOAuth.php`
    - `PHPMailer-master`
- **`model`**
    - `connexio.php`
    - `modelPaginacio.php`
    - `modelPersonatges.php`
    - `modelUsuaris.php`
- **`vista`**
    - `vistaAdministrarUsuaris.php`
    - `vistaApiPersonatges.php`
    - `vistaCanviContra.php`
    - `vistaConsultar.php`
    - `vistaCopiPersonatges.php`
    - `vistaEsborrar.php`
    - `vistaInserir.php`
    - `vistaLectorQR.php`
    - `vistaLogin.php`
    - `vistaMenu.php`
    - `vistaModificar.php`
    - `vistaModificarDades.php`
    - `vistaPerfil.php`
    - `vistaRecuperarContrasenya.php`
    - `vistaRegistrarse.php`
    - `vistaRestablirContra.php`
  - **`errors`**
  - **`imatges`**
    - **`imatgesUsers`**
- **`index.php`**
- **`.htaccess`**
- **`env.php`**
- **`.gitingore`**

# Funcionalitats del Projecte

### 1. **Còpia de Personatges** GESTIÓ PERSONATGES/CONSULTAR
- S'ha afegit un botó de **còpia** a cada personatge de la base de dades.
- Els usuaris registrats poden **crear una còpia similar** d'un personatge existent.
- Els usuaris poden seleccionar quins **dades específiques** del personatge volen copiar.

### 2. **Generació de Codi QR amb AJAX**
- S'ha incorporat **AJAX** per generar codis QR de manera dinàmica.
- Quan l'usuari selecciona les dades i envia la sol·licitud, el codi QR es genera automàticament.
- Un cop generat, es mostra un **modal** amb el codi QR.

### 3. **Lector de Codi QR al Perfil de l'Usuari** PERFIL/LECTOR QR
- Ara els usuaris poden **llegir codis QR** directament des del seu perfil.
- El lector escaneja el QR i redirigeix automàticament a la pestanya per **insertar personatges**, completant els camps amb les dades del codi QR.
- A més, s'ha afegit un **botó** en la generació del QR per redirigir directament al lector.

### 4. **Nova Secció: Arxiu Pirata** ARXIU PIRATA
- S'ha creat una nova secció a la **barra de navegació** anomenada **Arxiu Pirata**.
- Dins d'aquesta secció, es troben tres botons que recullen dades des d'una API externa:
  - Un botó per obtenir **tots els personatges** disponibles.
  - Un botó per filtrar personatges per **tripulació específica**.
  - Un botó per filtrar personatges per **recompensa**, extraient tots els pirates de *One Piece*.