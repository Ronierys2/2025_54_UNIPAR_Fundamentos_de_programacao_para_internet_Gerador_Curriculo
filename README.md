# Projeto Público – RONIERY SANTOS CARDOSO

**Projeto:** `2025_54_UNIPAR_Fundamentos_de_programacao_para_internet_Gerador_Curriculo`
**Status:** Público – uso LIVRE.

> Este repositório contém código-fonte desenvolvido por **RONIERY SANTOS CARDOSO**.

---

## 📌 Sobre

Página única em PHP + Bootstrap para montar currículo com seções dinâmicas e impressão/PDF via navegador
---

## ✅ Requisitos

* **PHP** ≥ 8.0 (recomendado 8.1+)
* **Servidor Web**: Apache 2.4+ (ou Nginx)
* **Timezone do PHP** configurada (ex.: `America/Sao_Paulo`)

---

## 📁 Estrutura (esperada)

```
OrdemPlus_Agerador_curriculoPI_Painel_php/
└─ index.php               # DocumentRoot (produção) / pasta servida
```

---

## 🔧 Instalação

> **Atenção**: Apenas pessoas autorizadas devem instalar/implantar.

1. **Clone o repositório**

   ```bash
   git clone https://github.com/Ronierys2/2025_54_UNIPAR_Fundamentos_de_programacao_para_internet_Gerador_Curriculo.git
   cd gerador_curriculo
   ```

2. **Servidor Web**

   * **Apache (recomendado)** – VirtualHost:

     ```apache
     <VirtualHost *:80>
         ServerName seu-dominio.com
         DocumentRoot "/caminho/gerador_curriculo"

         <Directory "/caminho/gerador_curriculo">
             AllowOverride All
             Require all granted
         </Directory>

         ErrorLog  "logs/gerador_curriculo-error.log"
         CustomLog "logs/gerador_curriculo-access.log" combined
     </VirtualHost>
     ```

   * **Nginx** – bloco básico:

     ```nginx
     server {
         server_name seu-dominio.com;
         root /var/www/gerador_curriculo;
         index index.php;

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ \.php$ {
             include fastcgi_params;
             fastcgi_pass unix:/run/php/php8.1-fpm.sock; # ajuste para sua versão/soquete
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         }
     }
     ```

3. **Execução local rápida (dev)**

   ```bash
   php -S 127.0.0.1:8000 -t gerador_curriculo
   ```

   Acesse: `http://127.0.0.1:8000`

---

## ▶️ Uso

* **Painel Web:** acesse a `BASE_URL` (ex.: `https://seu-dominio.com/`).

---

## 🕒 Changelog

* **v1.0.0**
* — Estrutura inicial do projeto.
* — Ajuste de diretorios do projeto.

---

## 🧑‍💻 Desenvolvedor Responsável

**Roniery Santos Cardoso**  
🌐 Site: [rscsistemas.com.br](https://rscsistemas.com.br)  
📧 E-mail: [roniery@rscsistemas.com.br](mailto:roniery@rscsistemas.com.br)  
📱 WhatsApp: [+55 92 4141-2737](https://wa.me/559241412737)  

---

## 🔒 Licença

Licenciado sob **Licença Pública Geral GNU**.
