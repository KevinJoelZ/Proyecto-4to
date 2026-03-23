<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - DeporteFit</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php
session_start();
require_once __DIR__ . '/conexión.php';
// Guard de admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_rol'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
$user_nombre = $_SESSION['user_nombre'] ?? 'Admin';
$user_email = $_SESSION['user_email'] ?? '';
?>

<header class="header">
  <div class="title">
    <i class="fas fa-shield-alt"></i>
    <span>Panel de Administración</span>
  </div>
  <div class="actions">
    <span style="opacity:.9; margin-right:10px;"><i class="fas fa-user"></i> <?php echo htmlspecialchars($user_nombre); ?></span>
    <a href="cliente.php?from=admin"><i class="fas fa-home"></i> Ir al sitio</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
  </div>
</header>

<div class="container">
  <div class="dashboard">
    <div class="tabs" id="tabs">
      <div class="tab active" data-tab="faqs"><i class="fas fa-question-circle"></i> FAQs</div>
      <div class="tab" data-tab="users"><i class="fas fa-users"></i> Usuarios</div>
      <div class="tab" data-tab="stats"><i class="fas fa-chart-line"></i> Estadísticas</div>
      <div class="tab" data-tab="forms"><i class="fas fa-file-alt"></i> Formularios</div>
    </div>

    <div class="tab-content active" id="tab-faqs">
      <div class="grid">
        <div class="card">
          <h3><i class="fas fa-plus-circle"></i> Crear / Editar FAQ</h3>
          <input type="hidden" id="faq-id">
          <label>Pregunta</label>
          <input class="input" id="faq-pregunta" placeholder="Escribe la pregunta">
          <label style="margin-top:8px; display:block">Respuesta</label>
          <textarea class="input" id="faq-respuesta" rows="5" placeholder="Escribe la respuesta"></textarea>
          <label style="margin-top:8px; display:block">Página destino</label>
          <select class="input" id="faq-page">
            <option value="cliente">Cliente (cliente.php)</option>
            <option value="servicios">Servicios (servicios.html)</option>
            <option value="entrenadores">Entrenadores (entrenadores.html)</option>
            <option value="planes">Planes (planes.html)</option>
            <option value="contacto">Contacto (contacto.html)</option>
          </select>
          <div style="margin-top:10px; display:flex; gap:.6rem;">
            <button class="btn primary" id="faq-guardar"><i class="fas fa-save"></i> Guardar</button>
            <button class="btn" id="faq-cancelar"><i class="fas fa-undo"></i> Cancelar</button>
            <span id="faq-notice" class="notice"></span>
          </div>
        </div>
        <div class="card">
          <h3><i class="fas fa-list"></i> Lista de FAQs</h3>
          <div style="display:flex; gap:.6rem; align-items:center; margin-bottom:.6rem;">
            <label for="faq-filter-page" class="muted">Filtrar por página:</label>
            <select id="faq-filter-page" class="input" style="max-width:240px">
              <option value="">Todas</option>
              <option value="cliente">Cliente</option>
              <option value="servicios">Servicios</option>
              <option value="entrenadores">Entrenadores</option>
              <option value="planes">Planes</option>
              <option value="contacto">Contacto</option>
            </select>
          </div>
          <table class="table" id="faq-table">
            <thead><tr><th>ID</th><th>Página</th><th>Pregunta</th><th>Respuesta</th><th>Acciones</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="tab-content" id="tab-users">
      <div class="card">
        <h3><i class="fas fa-users"></i> Usuarios Recientes</h3>
        <table class="table" id="users-table">
          <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Última Conexión</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <div class="tab-content" id="tab-stats">
      <div class="grid">
        <div class="card">
          <h3><i class="fas fa-edit"></i> Editar Estadísticas (Inicio)</h3>
          <div class="grid">
            <div>
              <label>Deportes</label>
              <input class="input" id="stat-deportes" placeholder="10+">
            </div>
            <div>
              <label>Entrenadores</label>
              <input class="input" id="stat-entrenadores" placeholder="30+">
            </div>
            <div>
              <label>Alumnos</label>
              <input class="input" id="stat-alumnos" placeholder="300+">
            </div>
            <div>
              <label>Alumnos Activos</label>
              <input class="input" id="stat-alumnos_activos" placeholder="250+">
            </div>
            <div>
              <label>Soporte</label>
              <input class="input" id="stat-soporte" placeholder="24/7">
            </div>
          </div>
          <div style="margin-top:10px; display:flex; gap:.6rem;">
            <button class="btn success" id="stats-guardar"><i class="fas fa-save"></i> Guardar</button>
            <span id="stats-notice" class="notice"></span>
          </div>
        </div>
        <div class="card">
          <h3><i class="fas fa-info-circle"></i> Instrucciones</h3>
          <p class="muted">Estos valores se muestran en la sección de estadísticas de la página de inicio del cliente. No requiere recargar si se consulta dinámicamente.</p>
        </div>
      </div>
    </div>

    <div class="tab-content" id="tab-forms">
      <div class="card">
        <h3><i class="fas fa-database"></i> Tablas de Formularios</h3>
        <div style="display:flex; gap:.6rem; align-items:center; flex-wrap:wrap; justify-content:center;">
          <input list="forms-tables" id="forms-table" class="input" placeholder="Escribe o selecciona una tabla" style="max-width:360px" />
          <datalist id="forms-tables"></datalist>
          <button class="btn primary" id="forms-cargar"><i class="fas fa-eye"></i> Cargar</button>
        </div>
        <div style="margin-top:10px; overflow:auto;">
          <table class="table" id="forms-table-data"><thead></thead><tbody></tbody></table>
        </div>
      </div>
      <div class="card" style="margin-top:12px;">
        <h3><i class="fas fa-lightbulb"></i> Sugerencias</h3>
        <p class="muted">Puedes escribir cualquier nombre de tabla existente en tu base de datos. Pulsa "Buscar Tablas" para ver todas las disponibles y elige desde la lista.
        Algunas tablas habituales: <b>usuarios</b>, <b>solicitudes</b>, <b>contacto</b>, <b>formularios</b>, <b>planes</b>, etc.</p>
      </div>
    </div>

  </div>
</div>

<script>
// Tabs
const tabs = document.querySelectorAll('.tab');
const tabContents = {
  faqs: document.getElementById('tab-faqs'),
  users: document.getElementById('tab-users'),
  stats: document.getElementById('tab-stats'),
  forms: document.getElementById('tab-forms'),
};
tabs.forEach(t => t.addEventListener('click', () => {
  document.querySelector('.tab.active')?.classList.remove('active');
  t.classList.add('active');
  Object.values(tabContents).forEach(el => el.classList.remove('active'));
  const id = t.dataset.tab;
  tabContents[id]?.classList.add('active');
  if (id === 'faqs') loadFaqs();
  if (id === 'users') loadUsers();
  if (id === 'stats') loadStats();
  if (id === 'forms') scanTables();
}));

// FAQs CRUD
async function loadFaqs(){
  const page = document.getElementById('faq-filter-page')?.value || '';
  const url = page ? `admin_api/faqs.php?action=list&page=${encodeURIComponent(page)}` : 'admin_api/faqs.php?action=list';
  const res = await fetch(url);
  const data = await res.json();
  const tbody = document.querySelector('#faq-table tbody');
  tbody.innerHTML = '';
  if (data?.items) {
    for (const it of data.items){
      const tr = document.createElement('tr');
      tr.innerHTML = `<td>${it.id}</td><td>${escapeHtml(it.page_slug||'')}</td><td>${escapeHtml(it.pregunta)}</td><td>${escapeHtml(it.respuesta)}</td>
        <td>
          <button class="btn" data-edit="${it.id}"><i class='fas fa-pen'></i></button>
          <button class="btn danger" data-del="${it.id}"><i class='fas fa-trash'></i></button>
        </td>`;
      tbody.appendChild(tr);
    }
  }
}

function escapeHtml(str){
  return (str??'').replace(/[&<>"]+/g, s=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[s]));
}

document.getElementById('faq-guardar').addEventListener('click', async ()=>{
  const id = document.getElementById('faq-id').value.trim();
  const pregunta = document.getElementById('faq-pregunta').value.trim();
  const respuesta = document.getElementById('faq-respuesta').value.trim();
  const page = document.getElementById('faq-page').value;
  const notice = document.getElementById('faq-notice');
  notice.textContent = '';
  if(!pregunta || !respuesta){ notice.textContent = 'Completa todos los campos'; notice.className='notice error'; return; }
  const action = id ? 'update' : 'create';
  const res = await fetch('admin_api/faqs.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action, id, pregunta, respuesta, page}) });
  const data = await res.json();
  if (data.success){ notice.textContent = 'Guardado correctamente'; notice.className='notice success'; document.getElementById('faq-id').value=''; document.getElementById('faq-pregunta').value=''; document.getElementById('faq-respuesta').value=''; loadFaqs(); }
  else { notice.textContent = data.message || 'Error'; notice.className='notice error'; }
});

document.getElementById('faq-cancelar').addEventListener('click', ()=>{
  document.getElementById('faq-id').value='';
  document.getElementById('faq-pregunta').value='';
  document.getElementById('faq-respuesta').value='';
  document.getElementById('faq-page').value='cliente';
  document.getElementById('faq-notice').textContent='';
});

document.querySelector('#faq-table tbody').addEventListener('click', async (e)=>{
  const editId = e.target.closest('button')?.dataset?.edit;
  const delId = e.target.closest('button')?.dataset?.del;
  if (editId){
    const row = e.target.closest('tr').children;
    document.getElementById('faq-id').value = editId;
    document.getElementById('faq-page').value = row[1].innerText || 'cliente';
    document.getElementById('faq-pregunta').value = row[2].innerText;
    document.getElementById('faq-respuesta').value = row[3].innerText;
  }
  if (delId){
    if (!confirm('¿Eliminar FAQ?')) return;
    const res = await fetch('admin_api/faqs.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'delete', id: delId}) });
    const data = await res.json();
    if (data.success) loadFaqs();
  }
});

// Filtro FAQs
document.getElementById('faq-filter-page').addEventListener('change', loadFaqs);

// Usuarios
async function loadUsers(){
  const res = await fetch('admin_api/users.php');
  const data = await res.json();
  const tbody = document.querySelector('#users-table tbody');
  tbody.innerHTML = '';
  for (const u of (data.items||[])){
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${u.id}</td><td>${escapeHtml(u.nombre||'')}</td><td>${escapeHtml(u.email||'')}</td><td>${escapeHtml(u.rol||'')}</td><td>${escapeHtml(u.ultima_conexion||'')}</td>`;
    tbody.appendChild(tr);
  }
}

// Estadísticas
async function loadStats(){
  const res = await fetch('admin_api/stats.php?action=get');
  const data = await res.json();
  const s = data.stats || {};
  document.getElementById('stat-deportes').value = s.deportes || '';
  document.getElementById('stat-entrenadores').value = s.entrenadores || '';
  document.getElementById('stat-alumnos').value = s.alumnos || '';
  document.getElementById('stat-alumnos_activos').value = s.alumnos_activos || '';
  document.getElementById('stat-soporte').value = s.soporte || '';
}
document.getElementById('stats-guardar').addEventListener('click', async ()=>{
  const payload = { action:'set', stats: {
    deportes: document.getElementById('stat-deportes').value,
    entrenadores: document.getElementById('stat-entrenadores').value,
    alumnos: document.getElementById('stat-alumnos').value,
    alumnos_activos: document.getElementById('stat-alumnos_activos').value,
    soporte: document.getElementById('stat-soporte').value,
  }};
  const res = await fetch('admin_api/stats.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload)});
  const data = await res.json();
  const notice = document.getElementById('stats-notice');
  if (data.success){ notice.textContent='Guardado'; notice.className='notice success'; }
  else { notice.textContent=data.message||'Error'; notice.className='notice error'; }
});

// Formularios
async function scanTables(){
  const res = await fetch('admin_api/forms.php?action=list_tables');
  const data = await res.json();
  const list = document.getElementById('forms-tables');
  list.innerHTML = '';
  for (const t of (data.tables||[])){
    const opt = document.createElement('option'); opt.value = t; list.appendChild(opt);
  }
}
async function loadTable(){
  const table = (document.getElementById('forms-table').value||'').trim();
  if (!table) return;
  const res = await fetch('admin_api/forms.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'fetch_table', table}) });
  const data = await res.json();
  const thead = document.querySelector('#forms-table-data thead');
  const tbody = document.querySelector('#forms-table-data tbody');
  thead.innerHTML = '';
  tbody.innerHTML = '';
  const items = data.items || [];
  if (items.length){
    const cols = Object.keys(items[0]);
    const trh = document.createElement('tr');
    trh.innerHTML = cols.map(c=>`<th>${escapeHtml(c)}</th>`).join('');
    thead.appendChild(trh);
    for (const row of items){
      const tr = document.createElement('tr');
      tr.innerHTML = Object.values(row).map(v=>`<td>${escapeHtml(String(v??''))}</td>`).join('');
      tbody.appendChild(tr);
    }
  }
}
document.getElementById('forms-cargar').addEventListener('click', loadTable);

// Inicial
loadFaqs();
// Precargar lista de tablas para el datalist
scanTables();
</script>
</body>
</html>