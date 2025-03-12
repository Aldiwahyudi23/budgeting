import{d as v,j as m,l as J,A as k,W as N,c as j,o as r,w,a as l,m as x,e as d,F as _,h,t as f,v as S,x as z,n as y,b as $,g as E,C as g}from"./app-Wyj5FL83.js";import{_ as O}from"./PrimaryButton-Dkhr-xqu.js";import{_ as L}from"./TextInput-dGIrg0mI.js";import{A as P}from"./AppLayout-D6vfLCj3.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const T={class:"p-4"},W={class:"flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4"},I=["value"],K=["value"],R={class:"mt-4 overflow-x-auto"},q={class:"min-w-full border bg-white rounded-lg shadow-md"},G={class:"px-4 py-2"},H=["onUpdate:modelValue","onChange"],Q={class:"px-4 py-2"},X={class:"px-4 py-2"},Z={class:"px-4 py-2"},oe={__name:"Allocation",props:{transactions:Array,categories:Array,filters:Object},setup(A){const n=A,u=v(n.filters.year||new Date().getFullYear().toString()),i=v(n.filters.month||(new Date().getMonth()+1).toString().padStart(2,"0")),o=v({}),c=v({}),C=m(()=>{const e=[];for(let s=2025;s<=2030;s++)e.push(s.toString());return e}),V=m(()=>[{value:"01",label:"Januari"},{value:"02",label:"Februari"},{value:"03",label:"Maret"},{value:"04",label:"April"},{value:"05",label:"Mei"},{value:"06",label:"Juni"},{value:"07",label:"Juli"},{value:"08",label:"Agustus"},{value:"09",label:"September"},{value:"10",label:"Oktober"},{value:"11",label:"November"},{value:"12",label:"Desember"}]);J(()=>{const t=`${u.value}-${i.value}`;o.value={},c.value={},n.transactions.forEach(a=>{a.date===t&&(o.value[a.category_id]=b(a.amount),c.value[a.category_id]=!0)})});const D=m(()=>n.categories);m(()=>{const t=`${u.value}-${i.value}`;return n.transactions.filter(a=>a.date===t)});const p=t=>c.value[t]!==void 0,M=t=>{const a=`${u.value}-${i.value}`,e=parseFloat(o.value[t].replace(/[^0-9.]/g,""));c.value[t]=e,g({category_id:t,amount:e,date:a}).post(route("allocation-ex.store"),{onSuccess:()=>{n.transactions.push({id:Date.now(),category_id:t,amount:e,date:a,category:n.categories.find(s=>s.id===t)}),o.value[t]=b(e)}})},B=t=>{const a=`${u.value}-${i.value}`,e=n.transactions.find(s=>s.category_id===t&&s.date===a);if(!e){alert("Data tidak ditemukan.");return}g({}).delete(route("allocation-ex.destroy",e.id),{onSuccess:()=>{const s=n.transactions.findIndex(F=>F.id===e.id);s!==-1&&n.transactions.splice(s,1),delete c.value[t],o.value[t]=""}})},U=t=>{g({is_active:t.is_active}).put(route("category_active",t.id))};k([u,i],([t,a])=>{N.get(route("allocation-ex.index"),{year:t,month:a},{preserveState:!1})});const b=t=>t?t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,"."):"",Y=(t,a)=>{let e=a.target.value.replace(/[^0-9]/g,"");o.value[t]=e,a.target.value=b(e)};return k(o,t=>{Object.keys(t).forEach(a=>{t[a]&&(o.value[a]=t[a])})},{deep:!0}),(t,a)=>(r(),j(P,{title:"Allocation"},{default:w(()=>[l("div",T,[l("div",W,[x(l("select",{"onUpdate:modelValue":a[0]||(a[0]=e=>u.value=e),class:"border rounded px-4 py-2 w-full md:w-48"},[a[2]||(a[2]=l("option",{value:""},"Pilih Tahun",-1)),(r(!0),d(_,null,h(C.value,e=>(r(),d("option",{key:e,value:e},f(e),9,I))),128))],512),[[S,u.value]]),x(l("select",{"onUpdate:modelValue":a[1]||(a[1]=e=>i.value=e),class:"border rounded px-4 py-2 w-full md:w-48"},[a[3]||(a[3]=l("option",{value:""},"Pilih Bulan",-1)),(r(!0),d(_,null,h(V.value,e=>(r(),d("option",{key:e.value,value:e.value},f(e.label),9,K))),128))],512),[[S,i.value]])]),l("div",R,[l("table",q,[a[4]||(a[4]=l("thead",{class:"bg-gray-200"},[l("tr",null,[l("th",{class:"px-4 py-2 text-left"},"Status"),l("th",{class:"px-4 py-2 text-left"},"Kategori"),l("th",{class:"px-4 py-2 text-left"},"Jumlah"),l("th",{class:"px-4 py-2 text-left"},"Aksi")])],-1)),l("tbody",null,[(r(!0),d(_,null,h(D.value,e=>(r(),d("tr",{key:e.id,class:"border-b hover:bg-gray-100"},[l("td",G,[x(l("input",{type:"checkbox","onUpdate:modelValue":s=>e.is_active=s,"true-value":1,"false-value":0,onChange:s=>U(e),class:"form-checkbox h-5 w-5 text-blue-600"},null,40,H),[[z,e.is_active]])]),l("td",Q,[l("span",{class:y({"text-red-500":!e.is_active})},f(e.name),3)]),l("td",X,[$(L,{modelValue:o.value[e.id],"onUpdate:modelValue":s=>o.value[e.id]=s,type:"text",class:"block w-full min-w-[150px]",disabled:p(e.id),onInput:s=>Y(e.id,s)},null,8,["modelValue","onUpdate:modelValue","disabled","onInput"])]),l("td",Z,[$(O,{onClick:s=>p(e.id)?B(e.id):M(e.id),class:y({"bg-green-600 hover:bg-green-700":!p(e.id),"bg-red-600 hover:bg-red-700":p(e.id)})},{default:w(()=>[E(f(p(e.id)?"Reset":"Simpan"),1)]),_:2},1032,["onClick","class"])])]))),128))])])])])]),_:1}))}};export{oe as default};
