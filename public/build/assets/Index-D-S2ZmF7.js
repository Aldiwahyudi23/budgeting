import{E as G,i as V,d as f,k as N,C as D,c as $,o as u,w as n,a as s,b as l,g as r,u as i,P as J,e as p,F as E,h as T,t as b,f as A,q as j,p as M,x as L,v as R}from"./app-nOn6-cWg.js";import{A as W}from"./AppLayout-8cUdJpmJ.js";import{_ as P}from"./CustomModal-DZAiD3fi.js";import{_ as v}from"./PrimaryButton-BrGtElcT.js";import{_ as F}from"./SecondaryButton-BwtRN858.js";import{_ as x}from"./InputLabel-D6v2H27H.js";import{_}from"./TextInput-C1rB3sNB.js";import{_ as k}from"./InputError-OPEAtuIp.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const X={class:"p-4"},Y={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},Z={class:"flex space-x-2"},ee={class:"relative"},se={class:"overflow-x-auto"},te={class:"min-w-full border bg-white rounded-lg shadow-md"},oe={class:"px-4 py-2"},le={class:"px-4 py-2"},ae=["checked","onChange"],ie={class:"px-4 py-2"},ne={class:"px-4 py-2"},de={class:"px-4 py-2 text-center"},re={key:0,class:"px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm"},ue={key:1,class:"px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm"},me={class:"px-4 py-2 text-center"},pe={class:"mb-4"},ce={class:"mb-4"},fe={class:"flex items-center"},be={class:"flex justify-end mt-4"},ve={class:"mb-4"},xe=["value","disabled"],_e={key:0},ke={class:"mb-4"},ye={class:"mb-4"},ge={class:"flex items-center"},Se={class:"flex justify-end mt-4"},Ee={__name:"Index",setup(we){const m=G([...V().props.sources]),g=f(!1),S=f(!1),c=f(!1),w=f(""),U=f(V().props.settings),I=N(()=>m.filter(o=>o.name.toLowerCase().includes(w.value.toLowerCase()))),a=D({...{id:"",name:"",description:"",is_active:!1}}),d=D({...{source_id:"",name:"",description:"",is_active:!1}}),B=(o,e=null)=>{c.value=o==="edit",c.value&&e?(a.id=e.id,a.name=e.name,a.description=e.description,a.is_active=!!e.is_active):a.reset(),g.value=!0},O=o=>{d.source_id=o.id,S.value=!0},y=()=>{a.reset(),g.value=!1},h=()=>{d.reset(),S.value=!1},q=()=>{c.value?a.put(route("source.update",a.id),{onSuccess:()=>{const o=m.findIndex(e=>e.id===a.id);o!==-1&&(m[o]={...a.data()}),y()}}):a.post(route("source.store"),{onSuccess:o=>{m.unshift(o.props.sources[0]),y()}})},z=()=>{d.post(route("sub-sources.store"),{onSuccess:()=>{h()}})},H=o=>{confirm("Apakah Anda yakin ingin menghapus sumber ini?")&&a.delete(route("source.destroy",o),{onSuccess:()=>{const e=m.findIndex(t=>t.id===o);e!==-1&&m.splice(e,1)}})};V().props.auth.user.id,N(()=>{const o={};return m.forEach(e=>{o[e.name]||(o[e.name]=[]),o[e.name].push(e)}),o});const K=async o=>{try{o.public=!o.public,await axios.patch(`/sources/${o.id}/update-public`,{public:o.public})}catch{category.public=!category.public}};return(o,e)=>(u(),$(W,{title:"Source"},{default:n(()=>[s("div",X,[e[24]||(e[24]=s("div",{class:"bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4"},[s("p",{class:"text-sm"}," Centang 'Publik' di bawah jika ingin data ini dapat digunakan oleh pengguna lain. ")],-1)),s("div",Y,[s("div",Z,[l(v,{onClick:e[0]||(e[0]=t=>B("create"))},{default:n(()=>e[9]||(e[9]=[r("Tambah Sumber (Source)")])),_:1}),l(i(J),{href:o.route("sources.manage"),class:"bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"},{default:n(()=>e[10]||(e[10]=[r(" Kelola Sumber ")])),_:1},8,["href"])]),s("div",ee,[l(_,{modelValue:w.value,"onUpdate:modelValue":e[1]||(e[1]=t=>w.value=t),placeholder:"Cari Source...",class:"pl-10 pr-4 py-2 border rounded-md w-64"},null,8,["modelValue"]),e[11]||(e[11]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])]),s("div",se,[s("table",te,[e[15]||(e[15]=s("thead",{class:"bg-gray-200"},[s("tr",null,[s("th",{class:"px-4 py-2 text-left"},"No"),s("th",{class:"px-4 py-2 text-center"},"public"),s("th",{class:"px-4 py-2 text-left"},"Nama"),s("th",{class:"px-4 py-2 text-left"},"Deskripsi"),s("th",{class:"px-4 py-2 text-center"},"Status"),s("th",{class:"px-4 py-2 text-center"},"Aksi")])],-1)),s("tbody",null,[(u(!0),p(E,null,T(I.value,(t,Q)=>(u(),p("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",oe,b(Q+1),1),s("td",le,[s("input",{type:"checkbox",checked:t.public,onChange:C=>K(t),class:"form-checkbox h-5 w-5 text-blue-600"},null,40,ae)]),s("td",ie,b(t.name),1),s("td",ne,b(t.description||"-"),1),s("td",de,[t.is_active?(u(),p("span",re,"Aktif")):(u(),p("span",ue,"Tidak Aktif"))]),s("td",me,[U.value.btn_edit?(u(),$(F,{key:0,onClick:C=>B("edit",t)},{default:n(()=>e[12]||(e[12]=[r("Edit")])),_:2},1032,["onClick"])):A("",!0),U.value.btn_delete?(u(),$(v,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:C=>H(t.id)},{default:n(()=>e[13]||(e[13]=[r("Hapus")])),_:2},1032,["onClick"])):A("",!0),l(v,{class:"ml-2 bg-blue-600 hover:bg-blue-700",onClick:C=>O(t)},{default:n(()=>e[14]||(e[14]=[r("+ Sub")])),_:2},1032,["onClick"])])]))),128))])])]),l(P,{show:g.value,title:c.value?"Edit Sumber (Source)":"Tambah Sumber (Source)",onClose:y},{content:n(()=>[s("form",{onSubmit:j(q,["prevent"])},[s("div",pe,[l(x,{for:"name"},{default:n(()=>e[16]||(e[16]=[r(" Nama Sumber (Source) "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),l(_,{id:"name",modelValue:i(a).name,"onUpdate:modelValue":e[2]||(e[2]=t=>i(a).name=t),class:"block w-full"},null,8,["modelValue"]),l(k,{message:i(a).errors.name},null,8,["message"])]),s("div",ce,[l(x,{for:"description",value:"Deskripsi"}),l(_,{id:"description",modelValue:i(a).description,"onUpdate:modelValue":e[3]||(e[3]=t=>i(a).description=t),class:"block w-full"},null,8,["modelValue"]),l(k,{message:i(a).errors.description},null,8,["message"])]),s("div",fe,[M(s("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[4]||(e[4]=t=>i(a).is_active=t),class:"mr-2"},null,512),[[L,i(a).is_active]]),e[17]||(e[17]=s("label",{for:"is_active"},"Aktif",-1))]),s("div",be,[l(F,{type:"button",onClick:y},{default:n(()=>e[18]||(e[18]=[r("Batal")])),_:1}),l(v,{class:"ml-3",type:"submit"},{default:n(()=>[r(b(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"]),l(P,{show:S.value,title:"Tambah Sub Sumber (Source)",onClose:h},{content:n(()=>[s("form",{onSubmit:j(z,["prevent"])},[s("div",ve,[l(x,{for:"source_id"},{default:n(()=>e[19]||(e[19]=[r(" Sumber (Source) "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),M(s("select",{id:"source_id","onUpdate:modelValue":e[5]||(e[5]=t=>i(d).source_id=t),class:"block w-full border rounded-md p-2"},[(u(!0),p(E,null,T(m,t=>(u(),p("option",{key:t.id,value:t.id,disabled:!t.is_active},[r(b(t.name)+" ",1),t.is_active?A("",!0):(u(),p("span",_e,"(Tidak Aktif)"))],8,xe))),128))],512),[[R,i(d).source_id]]),l(k,{message:i(d).errors.source_id},null,8,["message"])]),s("div",ke,[l(x,{for:"name"},{default:n(()=>e[20]||(e[20]=[r(" Nama Sub Sumber (Source) "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),l(_,{id:"name",modelValue:i(d).name,"onUpdate:modelValue":e[6]||(e[6]=t=>i(d).name=t),class:"block w-full"},null,8,["modelValue"]),l(k,{message:i(d).errors.name},null,8,["message"])]),s("div",ye,[l(x,{for:"description",value:"Deskripsi"}),l(_,{id:"description",modelValue:i(d).description,"onUpdate:modelValue":e[7]||(e[7]=t=>i(d).description=t),class:"block w-full"},null,8,["modelValue"]),l(k,{message:i(d).errors.description},null,8,["message"])]),s("div",ge,[M(s("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[8]||(e[8]=t=>i(d).is_active=t),class:"mr-2"},null,512),[[L,i(d).is_active]]),e[21]||(e[21]=s("label",{for:"is_active"},"Aktif",-1))]),s("div",Se,[l(F,{type:"button",onClick:h},{default:n(()=>e[22]||(e[22]=[r("Batal")])),_:1}),l(v,{class:"ml-3",type:"submit"},{default:n(()=>e[23]||(e[23]=[r("Simpan")])),_:1})])],32)]),_:1},8,["show"])])]),_:1}))}};export{Ee as default};
