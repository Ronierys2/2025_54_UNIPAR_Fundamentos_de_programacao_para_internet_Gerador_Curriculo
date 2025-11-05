<?php
?><!doctype html>
<html lang="pt-br" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gerador de Currículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f7f7fb; }
    .section-title { font-weight: 700; letter-spacing: .3px; }
    .required:after { content: ' *'; color: #dc3545; font-weight: 700; }
    .btn-icon { display: inline-flex; align-items: center; gap:.5rem; }
    .cv-preview { background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,.08); }
    .cv-header { border-bottom: 3px solid #0d6efd; }
    .cv-name { font-size: 1.8rem; font-weight: 800; letter-spacing:.2px; }
    .cv-contact i { width: 1.25rem; text-align: center; }
    .cv-avatar { width: 96px; height: 96px; border-radius: 12px; object-fit: cover; border: 3px solid #e9ecef; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
    .item-actions { opacity: .9; }
    .item-actions .btn { padding:.25rem .5rem; }
    .drag-handle { cursor: grab; }
    .badge-skill { font-size:.85rem; }

    /* PRINT: esconde painel de edição e mostra apenas preview */
    @media print {
      body { background: #fff; }
      #editor-col { display:none !important; }
      #preview-col { flex: 0 0 100% !important; max-width: 100% !important; }
      .cv-preview { box-shadow: none; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid no-print">
      <span class="navbar-brand fw-bold">Gerador de Currículo</span>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-icon" onclick="window.print()">
          <i class="bi bi-printer"></i> Imprimir / Salvar em PDF
        </button>
        <button class="btn btn-primary btn-icon" id="btnBaixarHTML">
          <i class="bi bi-download"></i> Baixar HTML
        </button>
      </div>
    </div>
  </nav>

  <main class="container my-4">
    <div class="row g-4">
      <!-- Coluna Editor -->
      <div class="col-12 col-lg-6" id="editor-col">
        <div class="card shadow-sm">
          <div class="card-body">
            <h2 class="h5 section-title mb-3">Dados Pessoais</h2>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label required">Nome completo</label>
                <input type="text" class="form-control" id="nome" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Cargo/Objetivo</label>
                <input type="text" class="form-control" id="objetivo" placeholder="Ex.: Desenvolvedor Delphi Pleno">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Localidade</label>
                <input type="text" class="form-control" id="local" placeholder="Cidade/Estado">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="voce@exemplo.com">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" placeholder="(00) 00000-0000">
              </div>
              <div class="col-12">
                <label class="form-label">Foto para o currículo</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                  <img id="fotoPreview" class="cv-avatar d-none" alt="Prévia da foto">
                  <div class="d-flex gap-2">
                    <input type="file" id="foto" accept="image/*" class="form-control" style="max-width:320px;">
                    <button type="button" id="btnRemFoto" class="btn btn-outline-secondary" title="Remover foto"><i class="bi bi-x-lg"></i></button>
                  </div>
                </div>
                <div class="form-text">Formatos: JPG/PNG. A imagem será posicionada no topo do currículo.</div>
              </div>
              <div class="col-12">
                <label class="form-label">Resumo profissional</label>
                <textarea class="form-control" id="resumo" rows="3" placeholder="Breve resumo de 2 a 4 linhas sobre sua experiência, resultados e diferenciais."></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Links (LinkedIn, Portfólio, GitHub...)</label>
                <input type="text" class="form-control" id="links" placeholder="Separe por ponto e vírgula ;">
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm mt-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 section-title m-0">Experiência Profissional</h2>
              <button class="btn btn-sm btn-success btn-icon" id="addExp"><i class="bi bi-plus-lg"></i> Adicionar</button>
            </div>
            <div id="expList" class="vstack gap-3"></div>
          </div>
        </div>

        <div class="card shadow-sm mt-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 section-title m-0">Formação Acadêmica</h2>
              <button class="btn btn-sm btn-success btn-icon" id="addEdu"><i class="bi bi-plus-lg"></i> Adicionar</button>
            </div>
            <div id="eduList" class="vstack gap-3"></div>
          </div>
        </div>

        <div class="card shadow-sm mt-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 section-title m-0">Habilidades</h2>
              <button class="btn btn-sm btn-success btn-icon" id="addSkill"><i class="bi bi-plus-lg"></i> Adicionar</button>
            </div>
            <div id="skillsList" class="d-flex flex-wrap gap-2"></div>
          </div>
        </div>

        <div class="alert alert-secondary mt-4">
          <div class="d-flex align-items-start gap-2">
            <i class="bi bi-info-circle fs-5"></i>
            <div>
              <strong>Dica:</strong> após preencher, clique em <em>Imprimir / Salvar em PDF</em> no topo. Na janela de impressão, selecione “Salvar como PDF”.
            </div>
          </div>
        </div>
      </div>

      <!-- Coluna Preview -->
      <div class="col-12 col-lg-6" id="preview-col">
        <div class="cv-preview card p-4">
          <header class="cv-header pb-3 mb-3">
            <img id="pvFoto" class="cv-avatar float-end d-none" alt="Foto do candidato">
            <div class="cv-name" id="pvNome">Seu Nome</div>
            <div class="text-muted" id="pvObjetivo">Seu cargo/objetivo</div>
            <div class="cv-contact small mt-2 d-flex flex-column gap-1">
              <div><i class="bi bi-geo-alt"></i> <span id="pvLocal">Cidade/Estado</span></div>
              <div><i class="bi bi-envelope"></i> <span id="pvEmail">email@exemplo.com</span></div>
              <div><i class="bi bi-telephone"></i> <span id="pvTelefone">(00) 00000-0000</span></div>
              <div class="d-none" id="pvLinksRow"><i class="bi bi-link-45deg"></i> <span id="pvLinks"></span></div>
            </div>
          </header>

          <section class="mb-3" id="pvResumoSec">
            <h3 class="h6 text-uppercase text-secondary">Resumo</h3>
            <p id="pvResumo" class="mb-0">Escreva um breve resumo profissional.</p>
          </section>

          <section class="mb-3 d-none" id="pvExpSec">
            <h3 class="h6 text-uppercase text-secondary">Experiência</h3>
            <div id="pvExpList" class="vstack gap-3"></div>
          </section>

          <section class="mb-3 d-none" id="pvEduSec">
            <h3 class="h6 text-uppercase text-secondary">Formação</h3>
            <div id="pvEduList" class="vstack gap-2"></div>
          </section>

          <section class="mb-2 d-none" id="pvSkillsSec">
            <h3 class="h6 text-uppercase text-secondary">Habilidades</h3>
            <div id="pvSkills" class="d-flex flex-wrap gap-2"></div>
          </section>
        </div>
      </div>
    </div>
  </main>

  <!-- Templates (para clonar via JS) -->
  <template id="tplExp">
    <div class="border rounded p-3 position-relative">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>Experiência</strong>
        <div class="item-actions">
          <button type="button" class="btn btn-outline-secondary btn-sm drag-handle" title="Arrastar"><i class="bi bi-arrows-move"></i></button>
          <button type="button" class="btn btn-outline-danger btn-sm btnDelExp" title="Remover"><i class="bi bi-trash"></i></button>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-12 col-md-7">
          <label class="form-label">Empresa</label>
          <input type="text" class="form-control inEmpresa" placeholder="Nome da empresa">
        </div>
        <div class="col-12 col-md-5">
          <label class="form-label">Cargo</label>
          <input type="text" class="form-control inCargo" placeholder="Seu cargo">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label">Início</label>
          <input type="month" class="form-control inInicio">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label">Término</label>
          <input type="month" class="form-control inFim" placeholder="ou deixe em branco se atual">
        </div>
        <div class="col-12">
          <label class="form-label">Descrição / Realizações</label>
          <textarea class="form-control inDesc" rows="3" placeholder="Principais atividades, tecnologias usadas e resultados."></textarea>
        </div>
      </div>
    </div>
  </template>

  <template id="tplEdu">
    <div class="border rounded p-3 position-relative">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>Formação</strong>
        <div class="item-actions">
          <button type="button" class="btn btn-outline-danger btn-sm btnDelEdu" title="Remover"><i class="bi bi-trash"></i></button>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label">Curso</label>
          <input type="text" class="form-control inCurso" placeholder="Ex.: Bacharelado em Ciência da Computação">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Instituição</label>
          <input type="text" class="form-control inInst" placeholder="Universidade X">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label">Início</label>
          <input type="month" class="form-control inEduInicio">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label">Conclusão</label>
          <input type="month" class="form-control inEduFim">
        </div>
      </div>
    </div>
  </template>

  <template id="tplSkill">
    <div class="input-group skill-line" style="max-width:520px;">
      <input type="text" class="form-control inSkill" placeholder="Ex.: Delphi, PHP, MySQL, REST">
      <button class="btn btn-outline-danger btnDelSkill" type="button" title="Remover"><i class="bi bi-x"></i></button>
    </div>
  </template>

  <script>
    // Util: escapa HTML básico
    function esc(s){ return (s||'').toString().replace(/[&<>"]+/g, m=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[m])); }

    // DOM refs Preview
    const pv = {
      nome: document.getElementById('pvNome'),
      objetivo: document.getElementById('pvObjetivo'),
      local: document.getElementById('pvLocal'),
      email: document.getElementById('pvEmail'),
      telefone: document.getElementById('pvTelefone'),
      resumo: document.getElementById('pvResumo'),
      resumoSec: document.getElementById('pvResumoSec'),
      linksRow: document.getElementById('pvLinksRow'),
      links: document.getElementById('pvLinks'),
      expSec: document.getElementById('pvExpSec'),
      expList: document.getElementById('pvExpList'),
      eduSec: document.getElementById('pvEduSec'),
      eduList: document.getElementById('pvEduList'),
      skillsSec: document.getElementById('pvSkillsSec'),
      skills: document.getElementById('pvSkills'),
      foto: document.getElementById('pvFoto')
    };

    // DOM refs Editor
    const inNome = document.getElementById('nome');
    const inObj  = document.getElementById('objetivo');
    const inLoc  = document.getElementById('local');
    const inMail = document.getElementById('email');
    const inTel  = document.getElementById('telefone');
    const inResumo = document.getElementById('resumo');
    const inLinks = document.getElementById('links');
    const inFoto  = document.getElementById('foto');
    const fotoPreview = document.getElementById('fotoPreview');
    const btnRemFoto  = document.getElementById('btnRemFoto');

    function syncHeader(){
      pv.nome.textContent     = inNome.value || 'Seu Nome';
      pv.objetivo.textContent = inObj.value || 'Seu cargo/objetivo';
      pv.local.textContent    = inLoc.value || 'Cidade/Estado';
      pv.email.textContent    = inMail.value || 'email@exemplo.com';
      pv.telefone.textContent = inTel.value || '(00) 00000-0000';
      const resumo = inResumo.value.trim();
      if(resumo){ pv.resumo.textContent = resumo; pv.resumoSec.classList.remove('d-none'); }
      else { pv.resumo.textContent = 'Escreva um breve resumo profissional.'; pv.resumoSec.classList.remove('d-none'); }
      const links = (inLinks.value||'').split(';').map(v=>v.trim()).filter(Boolean);
      if(links.length){
        pv.links.innerHTML = links.map(l=>`<a href="${esc(l)}" target="_blank">${esc(l)}</a>`).join(' · ');
        pv.linksRow.classList.remove('d-none');
      } else {
        pv.linksRow.classList.add('d-none');
        pv.links.innerHTML = '';
      }
    }
    [inNome,inObj,inLoc,inMail,inTel,inResumo,inLinks].forEach(inp=>inp.addEventListener('input', syncHeader));

    // Experiências dinâmicas
    const expList = document.getElementById('expList');
    const tplExp = document.getElementById('tplExp');
    function addExp(data={}){
      const node = tplExp.content.firstElementChild.cloneNode(true);
      node.querySelector('.inEmpresa').value = data.empresa||'';
      node.querySelector('.inCargo').value = data.cargo||'';
      node.querySelector('.inInicio').value = data.inicio||'';
      node.querySelector('.inFim').value = data.fim||'';
      node.querySelector('.inDesc').value = data.desc||'';
      node.querySelector('.btnDelExp').addEventListener('click', ()=>{ node.remove(); renderExpPreview(); });
      expList.appendChild(node);
      attachExpInputs(node);
      renderExpPreview();
    }
    function attachExpInputs(node){
      node.querySelectorAll('input,textarea').forEach(el=>{
        el.addEventListener('input', renderExpPreview);
      });
    }
    function renderExpPreview(){
      const items = [...expList.querySelectorAll('.border.rounded')].map(box=>({
        empresa: box.querySelector('.inEmpresa').value.trim(),
        cargo:   box.querySelector('.inCargo').value.trim(),
        inicio:  box.querySelector('.inInicio').value,
        fim:     box.querySelector('.inFim').value,
        desc:    box.querySelector('.inDesc').value.trim()
      })).filter(it=>it.empresa||it.cargo||it.desc);

      pv.expList.innerHTML = '';
      if(!items.length){ pv.expSec.classList.add('d-none'); return; }
      pv.expSec.classList.remove('d-none');

      items.forEach(it=>{
        const period = [it.inicio, it.fim].filter(Boolean).join(' — ');
        const div = document.createElement('div');
        div.innerHTML = `
          <div>
            <div class="d-flex justify-content-between flex-wrap">
              <div class="fw-semibold">${esc(it.cargo||'')}</div>
              <div class="text-muted small">${esc(period)}</div>
            </div>
            <div class="text-primary small">${esc(it.empresa||'')}</div>
            ${it.desc ? `<div class="mt-1">${esc(it.desc)}</div>` : ''}
          </div>`;
        pv.expList.appendChild(div);
      });
    }
    document.getElementById('addExp').addEventListener('click', ()=>addExp());

    // Formação
    const eduList = document.getElementById('eduList');
    const tplEdu = document.getElementById('tplEdu');
    function addEdu(data={}){
      const node = tplEdu.content.firstElementChild.cloneNode(true);
      node.querySelector('.inCurso').value = data.curso||'';
      node.querySelector('.inInst').value = data.inst||'';
      node.querySelector('.inEduInicio').value = data.inicio||'';
      node.querySelector('.inEduFim').value = data.fim||'';
      node.querySelector('.btnDelEdu').addEventListener('click', ()=>{ node.remove(); renderEduPreview(); });
      eduList.appendChild(node);
      node.querySelectorAll('input').forEach(el=>el.addEventListener('input', renderEduPreview));
      renderEduPreview();
    }
    function renderEduPreview(){
      const items = [...eduList.querySelectorAll('.border.rounded')].map(box=>({
        curso:  box.querySelector('.inCurso').value.trim(),
        inst:   box.querySelector('.inInst').value.trim(),
        inicio: box.querySelector('.inEduInicio').value,
        fim:    box.querySelector('.inEduFim').value
      })).filter(it=>it.curso||it.inst);

      pv.eduList.innerHTML = '';
      if(!items.length){ pv.eduSec.classList.add('d-none'); return; }
      pv.eduSec.classList.remove('d-none');

      items.forEach(it=>{
        const period = [it.inicio, it.fim].filter(Boolean).join(' — ');
        const div = document.createElement('div');
        div.innerHTML = `
          <div class="d-flex justify-content-between flex-wrap">
            <div><strong>${esc(it.curso)}</strong> <span class="text-primary">• ${esc(it.inst)}</span></div>
            <div class="text-muted small">${esc(period)}</div>
          </div>`;
        pv.eduList.appendChild(div);
      });
    }
    document.getElementById('addEdu').addEventListener('click', ()=>addEdu());

    // Habilidades
    const skillsList = document.getElementById('skillsList');
    const tplSkill = document.getElementById('tplSkill');
    function addSkill(val=''){
      const node = tplSkill.content.firstElementChild.cloneNode(true);
      const input = node.querySelector('.inSkill');
      input.value = val;
      node.querySelector('.btnDelSkill').addEventListener('click', ()=>{ node.remove(); renderSkillsPreview(); });
      input.addEventListener('input', renderSkillsPreview);
      skillsList.appendChild(node);
      renderSkillsPreview();
    }
    function renderSkillsPreview(){
      const vals = [...skillsList.querySelectorAll('.inSkill')]
        .map(i=>i.value.trim()).filter(Boolean);
      pv.skills.innerHTML = '';
      if(!vals.length){ pv.skillsSec.classList.add('d-none'); return; }
      pv.skillsSec.classList.remove('d-none');
      vals.forEach(v=>{
        const b = document.createElement('span');
        b.className = 'badge text-bg-light border badge-skill';
        b.textContent = v;
        pv.skills.appendChild(b);
      });
    }
    document.getElementById('addSkill').addEventListener('click', ()=>addSkill());

    // Baixar HTML (estático) da visualização atual
    document.getElementById('btnBaixarHTML').addEventListener('click', ()=>{
      const html = `<!doctype html><html lang=\"pt-br\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width\">`+
        `<title>Curriculo - ${esc(inNome.value||'Sem Nome')}</title>`+
        `<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\">`+
        `<style>body{padding:24px} .cv-header{border-bottom:3px solid #0d6efd}.cv-name{font-size:1.8rem;font-weight:800}</style>`+
        `</head><body>` + document.querySelector('.cv-preview').outerHTML + `</body></html>`;
      const blob = new Blob([html], {type:'text/html'});
      const a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = 'curriculo_'+(inNome.value||'sem_nome').replace(/\s+/g,'_')+'.html';
      a.click();
      URL.revokeObjectURL(a.href);
    });

    // Foto: carregar e sincronizar
    function setFotoSrc(src){
      if(src){ pv.foto.src = src; pv.foto.classList.remove('d-none'); fotoPreview.src = src; fotoPreview.classList.remove('d-none'); }
      else { pv.foto.src = ''; pv.foto.classList.add('d-none'); fotoPreview.src=''; fotoPreview.classList.add('d-none'); }
    }
    inFoto.addEventListener('change', ()=>{
      const f = inFoto.files && inFoto.files[0];
      if(!f) return setFotoSrc('');
      if(!f.type.startsWith('image/')){ alert('Selecione uma imagem válida.'); inFoto.value=''; return; }
      const reader = new FileReader();
      reader.onload = e => setFotoSrc(e.target.result);
      reader.readAsDataURL(f);
    });
    btnRemFoto.addEventListener('click', ()=>{ inFoto.value=''; setFotoSrc(''); });

    // Estado inicial
    syncHeader();
    addExp({empresa:'Empresa Exemplo', cargo:'Desenvolvedor', inicio:'2023-01', fim:'', desc:'Desenvolvimento de sistemas, integrações REST e otimização de consultas SQL.'});
    addEdu({curso:'Tecnologia em Análise e Desenvolvimento de Sistemas', inst:'Faculdade X', inicio:'2018-01', fim:'2020-12'});
    addSkill('Delphi'); addSkill('PHP'); addSkill('MySQL');

    const s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js';
    s.onload = ()=>{ new Sortable(expList, { handle: '.drag-handle', animation: 150, onSort: renderExpPreview }); };
    document.head.appendChild(s);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>