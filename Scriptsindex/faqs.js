// Simple FAQ renderer for DeporteFit
// Usage: loadFaqs('cliente', '#faqs-dynamic')
async function loadFaqs(pageSlug, containerSelector){
  try {
    const res = await fetch(`admin_api/faqs.php?action=list&page=${encodeURIComponent(pageSlug)}`);
    if (!res.ok) return;
    const data = await res.json();
    const items = data.items || [];
    const container = document.querySelector(containerSelector);
    if (!container) return;

    if (!items.length){
      container.innerHTML = '<p class="muted">Aún no hay preguntas frecuentes para esta sección.</p>';
      return;
    }

    // Build collapsible list styled similar to existing FAQ cards
    const list = document.createElement('div');
    list.style.display = 'grid';
    // Formato menos compacto para 'servicios' (similar a entrenadores)
    const isServicios = String(pageSlug||'').toLowerCase() === 'servicios';
    list.style.gridTemplateColumns = '1fr 1fr';
    list.style.gap = isServicios ? '1.6rem' : '1.2rem';
    list.style.maxWidth = '900px';
    list.style.margin = '0 auto';

    items.forEach(it => {
      const item = document.createElement('div');
      item.className = 'faq-item';
      item.style.background = '#fff';
      item.style.borderRadius = '1.1rem';
      item.style.boxShadow = '0 2px 12px rgba(25,118,210,0.07)';
      item.style.padding = isServicios ? '1.4rem 1.2rem' : '1.2rem 1rem';

      const btn = document.createElement('button');
      btn.className = 'faq-question';
      btn.style.background = 'none';
      btn.style.border = 'none';
      btn.style.fontWeight = '600';
      btn.style.fontSize = isServicios ? '1.12rem' : '1.05rem';
      btn.style.color = '#1976d2';
      btn.style.display = 'flex';
      btn.style.alignItems = 'center';
      btn.style.gap = '.7rem';
      btn.style.cursor = 'pointer';
      btn.style.width = '100%';
      btn.style.textAlign = 'left';
      btn.innerHTML = `<i class="fas fa-question-circle" style="color:#ff9800;"></i> ${escapeHtml(it.pregunta)}`;

      const ans = document.createElement('div');
      ans.className = 'faq-answer';
      ans.style.display = 'none';
      ans.style.marginTop = isServicios ? '.85rem' : '.7rem';
      ans.style.color = '#333';
      ans.innerText = it.respuesta || '';

      btn.addEventListener('click', ()=>{
        ans.style.display = ans.style.display === 'none' ? 'block' : 'none';
      });

      item.appendChild(btn);
      item.appendChild(ans);
      list.appendChild(item);
    });

    container.innerHTML = '';
    // Optional title
    const h = document.createElement('h3');
    h.textContent = 'Preguntas Frecuentes (dinámicas)';
    h.style.textAlign = 'center';
    h.style.color = '#1976d2';
    h.style.fontWeight = '700';
    h.style.fontSize = '1.4rem';
    h.style.margin = '1rem 0';

    container.appendChild(h);
    container.appendChild(list);
  } catch (e) {
    // silent
  }
}

function escapeHtml(str){
  return String(str||'').replace(/[&<>"']/g, s=>({
    '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'
  }[s]));
}
