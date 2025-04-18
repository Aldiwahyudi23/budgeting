import{d as v,k as f,m as B,j as N,W as J,c as z,o as r,w as g,a as l,p as _,e as d,F as x,h,t as m,v as w,y as Y,n as k,b as S,g as j,C as y}from"./app-BrPtzkkN.js";import{A as E}from"./AppLayout-C79_jNCB.js";import{_ as L}from"./PrimaryButton-WwNLqnzx.js";import{_ as O}from"./TextInput-5Kd50gVj.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./NavLink-DlF4K_pY.js";const P={class:"p-4"},R={class:"flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4"},T=["value"],W=["value"],q={class:"mt-4 overflow-x-auto"},G={class:"min-w-full border bg-white rounded-lg shadow-md"},H={class:"px-4 py-2"},K=["onUpdate:modelValue","onChange"],Q={class:"px-4 py-2"},X={class:"px-4 py-2"},Z={class:"px-4 py-2"},ue={__name:"Allocation",props:{transactions:Array,sources:Array,filters:Object},setup(V){const n=V,u=v(n.filters.year||new Date().getFullYear().toString()),i=v(n.filters.month||(new Date().getMonth()+1).toString().padStart(2,"0")),o=v({}),c=v({}),$=v(Array.from({length:10},(a,t)=>new Date().getFullYear()-t)),A=f(()=>[{value:"01",label:"Januari"},{value:"02",label:"Februari"},{value:"03",label:"Maret"},{value:"04",label:"April"},{value:"05",label:"Mei"},{value:"06",label:"Juni"},{value:"07",label:"Juli"},{value:"08",label:"Agustus"},{value:"09",label:"September"},{value:"10",label:"Oktober"},{value:"11",label:"November"},{value:"12",label:"Desember"}]);B(()=>{const a=`${u.value}-${i.value}`;o.value={},c.value={},n.transactions.forEach(t=>{t.date===a&&(o.value[t.source_id]=b(t.amount),c.value[t.source_id]=!0)})});const D=f(()=>n.sources);f(()=>{const a=`${u.value}-${i.value}`;return n.transactions.filter(t=>t.date===a)});const p=a=>c.value[a]!==void 0,C=a=>{const t=`${u.value}-${i.value}`,e=parseFloat(o.value[a].replace(/[^0-9.]/g,""));c.value[a]=e,y({source_id:a,amount:e,date:t}).post(route("allocation-in.store"),{onSuccess:()=>{n.transactions.push({id:Date.now(),source_id:a,amount:e,date:t,source:n.sources.find(s=>s.id===a)}),o.value[a]=b(e)}})},F=a=>{const t=`${u.value}-${i.value}`,e=n.transactions.find(s=>s.source_id===a&&s.date===t);if(!e){alert("Data tidak ditemukan.");return}y({}).delete(route("allocation-in.destroy",e.id),{onSuccess:()=>{const s=n.transactions.findIndex(U=>U.id===e.id);s!==-1&&n.transactions.splice(s,1),delete c.value[a],o.value[a]=""}})},M=a=>{y({is_active:a.is_active}).put(route("source_active",a.id))},b=a=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(a),I=(a,t)=>{const s=t.target.value.replace(/[^0-9.]/g,"");o.value[a]=s,t.target.value=b(s)};return N([u,i],([a,t])=>{J.get(route("allocation-in.index"),{year:a,month:t},{preserveState:!1})}),(a,t)=>(r(),z(E,{title:"Allocation Source"},{default:g(()=>[l("div",P,[l("div",R,[_(l("select",{"onUpdate:modelValue":t[0]||(t[0]=e=>u.value=e),class:"border rounded px-4 py-2 w-full md:w-48"},[t[2]||(t[2]=l("option",{value:""},"Pilih Tahun",-1)),(r(!0),d(x,null,h($.value,e=>(r(),d("option",{key:e,value:e},m(e),9,T))),128))],512),[[w,u.value]]),_(l("select",{"onUpdate:modelValue":t[1]||(t[1]=e=>i.value=e),class:"border rounded px-4 py-2 w-full md:w-48"},[t[3]||(t[3]=l("option",{value:""},"Pilih Bulan",-1)),(r(!0),d(x,null,h(A.value,e=>(r(),d("option",{key:e.value,value:e.value},m(e.label),9,W))),128))],512),[[w,i.value]])]),l("div",q,[l("table",G,[t[4]||(t[4]=l("thead",{class:"bg-gray-200"},[l("tr",null,[l("th",{class:"px-4 py-2 text-left"},"Status"),l("th",{class:"px-4 py-2 text-left"},"Sumber"),l("th",{class:"px-4 py-2 text-left"},"Jumlah"),l("th",{class:"px-4 py-2 text-left"},"Aksi")])],-1)),l("tbody",null,[(r(!0),d(x,null,h(D.value,e=>(r(),d("tr",{key:e.id,class:"border-b hover:bg-gray-100"},[l("td",H,[_(l("input",{type:"checkbox","onUpdate:modelValue":s=>e.is_active=s,"true-value":1,"false-value":0,onChange:s=>M(e),class:"form-checkbox h-5 w-5 text-blue-600"},null,40,K),[[Y,e.is_active]])]),l("td",Q,[l("span",{class:k({"text-red-500":!e.is_active})},m(e.name),3)]),l("td",X,[S(O,{modelValue:o.value[e.id],"onUpdate:modelValue":s=>o.value[e.id]=s,type:"text",class:"block w-full min-w-[150px]",disabled:p(e.id),onInput:s=>I(e.id,s)},null,8,["modelValue","onUpdate:modelValue","disabled","onInput"])]),l("td",Z,[S(L,{onClick:s=>p(e.id)?F(e.id):C(e.id),class:k({"bg-green-600 hover:bg-green-700":!p(e.id),"bg-red-600 hover:bg-red-700":p(e.id)})},{default:g(()=>[j(m(p(e.id)?"Reset":"Simpan"),1)]),_:2},1032,["onClick","class"])])]))),128))])])])])]),_:1}))}};export{ue as default};
