document.addEventListener('DOMContentLoaded', () => {
    const chatBody = document.getElementById('chatBody');
    const input    = document.getElementById('userInput');
    const sendBtn  = document.getElementById('sendBtn');
    const lastActive = document.getElementById('lastActive');
    const quickRow = document.getElementById('quickRow');
  
    const defaultQuick = [
      'Hello','Order problem help','Track order',
      'Return/Refund','Payment problem','Change address',
      'Support hours','Contact support','Calculator'
    ];
  
    function setLastActive(){
      const n = Math.floor(Math.random()*8)+2;
      lastActive.textContent = `Last Active (${n} mins ago)`;
    }
  
    function addMsg(role,text){
      const row = document.createElement('div');
      row.className = 'row ' + role;
      const bubble = document.createElement('div');
      bubble.className = 'bubble';
      bubble.textContent = text;
      row.appendChild(bubble);
      chatBody.appendChild(row);
      chatBody.scrollTop = chatBody.scrollHeight;
    }
  
    function setQuickEnabled(on){
      Array.from(quickRow.querySelectorAll('.quick')).forEach(b=>b.disabled=!on);
    }
  
    function renderQuick(list){
      quickRow.innerHTML = '';
      list.forEach(t=>{
        const b = document.createElement('button');
        b.className = 'quick';
        b.textContent = t;
        b.addEventListener('click',()=>sendMessage(t)); // send immediately
        quickRow.appendChild(b);
      });
    }
  
    function disableComposer(state){
      input.disabled = state;
      sendBtn.disabled = state;
      setQuickEnabled(!state);
    }
  
    const sleep = (ms)=>new Promise(r=>setTimeout(r,ms));
  
    function showTyping(){
      lastActive.textContent='Typing…';
      const row = document.createElement('div');
      row.className='row bot typing-row';
      const bubble=document.createElement('div');
      bubble.className='bubble typing';
      bubble.innerHTML='<span class="dot"></span><span class="dot"></span><span class="dot"></span>';
      row.appendChild(bubble);
      chatBody.appendChild(row);
      chatBody.scrollTop=chatBody.scrollHeight;
      return { remove(){ row.remove(); } };
    }
  
    function typeReply(text){
      return new Promise(resolve=>{
        const row=document.createElement('div');
        row.className='row bot';
        const bubble=document.createElement('div');
        bubble.className='bubble bot-type';
        const caret=document.createElement('span');
        caret.className='caret';
        bubble.appendChild(document.createTextNode(''));
        bubble.appendChild(caret);
        row.appendChild(bubble);
        chatBody.appendChild(row);
        chatBody.scrollTop=chatBody.scrollHeight;
  
        let i=0, len=text.length;
        const base=14, jitter=8;
        (function step(){
          if(i<=len){
            bubble.firstChild.nodeValue=text.slice(0,i);
            chatBody.scrollTop=chatBody.scrollHeight;
            i++;
            setTimeout(step, base+Math.floor(Math.random()*jitter));
          }else{
            caret.remove();
            resolve();
          }
        })();
      });
    }
  
    async function sendMessage(text){
      const v=(text??input.value).trim();
      if(!v) return;
      if(!text){ input.value=''; }
      addMsg('user',v);
      disableComposer(true);
      const t0=performance.now();
      const typing=showTyping();
      try{
        // Central router
        const r=await fetch('../response/router.php', {
          method:'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
          body: new URLSearchParams({ q: v })
        });
        const data=await r.json();
  
        const delays=[2000,3000,4000,5000,6000,7000,8000,9000,10000];
        const target=delays[Math.floor(Math.random()*delays.length)];
        const elapsed=performance.now()-t0;
        const wait=Math.max(0,target-elapsed);
        await sleep(wait);
  
        typing.remove();
        await typeReply(data.reply||'');
        renderQuick(Array.isArray(data.quick)&&data.quick.length?data.quick:defaultQuick);
        lastActive.textContent='Online now';
      }catch(e){
        typing.remove();
        addMsg('bot','Sorry, something went wrong.');
      }finally{
        disableComposer(false);
      }
    }
  
    sendBtn.addEventListener('click',()=>sendMessage());
    input.addEventListener('keydown',e=>{ if(e.key==='Enter'){ sendMessage(); }});
  
    // init
    setLastActive();
    addMsg('bot','Hi! I’m Omacha-Shop Customer Care. Ask me anything or tap a quick chat.');
    renderQuick(defaultQuick);
  });
  