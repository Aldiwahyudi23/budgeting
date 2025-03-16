import{B as J,i as K,d as f,k as P,C as N,c as C,o as u,w as r,a as s,b as o,g as d,e as p,F,h as D,t as v,f as h,q as T,u as a,p as A,y as j,v as R}from"./app-DtA5733D.js";import{_ as E}from"./CustomModal-D1a3s5M1.js";import{_}from"./PrimaryButton-O6V9uCDG.js";import{_ as M}from"./SecondaryButton-CrGhkVUd.js";import{_ as b}from"./InputLabel-D7zUsoe5.js";import{_ as g}from"./TextInput-C0sWp2z-.js";import{_ as x}from"./InputError-Bac3FOop.js";import{A as W}from"./AppLayout-03gcdPRa.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const X={class:"p-4"},Y={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},Z={class:"relative"},ee={class:"mt-4 overflow-x-auto"},se={class:"min-w-full border bg-white rounded-lg shadow-md"},te={class:"px-4 py-2"},oe={class:"px-4 py-2"},le={class:"px-4 py-2"},ae={class:"px-4 py-2 text-center"},ie={key:0,class:"px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm"},ne={key:1,class:"px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm"},re={class:"px-4 py-2 text-center"},de={class:"mb-4"},ue={class:"mb-4"},me={class:"flex items-center"},pe={class:"flex justify-end mt-4"},ce={class:"mb-4"},fe=["value","disabled"],ve={key:0},_e={class:"mb-4"},be={class:"mb-4"},ge={class:"flex items-center"},xe={class:"flex justify-end mt-4"},Be={__name:"Index",setup(ye){const m=J([...K().props.categories]),k=f(!1),w=f(!1),c=f(!1),S=f(""),$=f(K().props.settings),L=P(()=>m.filter(n=>n.name.toLowerCase().includes(S.value.toLowerCase()))),I={id:"",name:"",description:"",is_active:!1},q={category_id:"",name:"",description:"",is_active:!1},l=N({...I}),i=N({...q}),B=(n,e=null)=>{c.value=n==="edit",c.value&&e?(l.id=e.id,l.name=e.name,l.description=e.description,l.is_active=!!e.is_active):l.reset(),k.value=!0},O=n=>{i.category_id=n.id,w.value=!0},y=()=>{l.reset(),k.value=!1},V=()=>{i.reset(),w.value=!1},z=()=>{c.value?l.put(route("category.update",l.id),{onSuccess:()=>{const n=m.findIndex(e=>e.id===l.id);n!==-1&&(m[n]={...l.data()}),y()}}):l.post(route("category.store"),{onSuccess:n=>{m.unshift(n.props.categories[0]),y()}})},H=()=>{i.post(route("sub-category.store"),{onSuccess:()=>{V()}})},Q=n=>{confirm("Apakah Anda yakin ingin menghapus kategori ini?")&&l.delete(route("category.destroy",n),{onSuccess:()=>{const e=m.findIndex(t=>t.id===n);e!==-1&&m.splice(e,1)}})};return(n,e)=>(u(),C(W,{title:"Category"},{default:r(()=>[s("div",X,[s("div",Y,[o(_,{onClick:e[0]||(e[0]=t=>B("create"))},{default:r(()=>e[9]||(e[9]=[d("Tambah Kategori")])),_:1}),s("div",Z,[o(g,{modelValue:S.value,"onUpdate:modelValue":e[1]||(e[1]=t=>S.value=t),placeholder:"Cari Kategori...",class:"pl-10 pr-4 py-2 border rounded-md w-64"},null,8,["modelValue"]),e[10]||(e[10]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])]),s("div",ee,[s("table",se,[e[14]||(e[14]=s("thead",{class:"bg-gray-200"},[s("tr",null,[s("th",{class:"px-4 py-2 text-left"},"No"),s("th",{class:"px-4 py-2 text-left"},"Nama"),s("th",{class:"px-4 py-2 text-left"},"Deskripsi"),s("th",{class:"px-4 py-2 text-center"},"Status"),s("th",{class:"px-4 py-2 text-center"},"Aksi")])],-1)),s("tbody",null,[(u(!0),p(F,null,D(L.value,(t,G)=>(u(),p("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",te,v(G+1),1),s("td",oe,v(t.name),1),s("td",le,v(t.description||"-"),1),s("td",ae,[t.is_active?(u(),p("span",ie,"Aktif")):(u(),p("span",ne,"Tidak Aktif"))]),s("td",re,[$.value.btn_edit?(u(),C(M,{key:0,onClick:U=>B("edit",t)},{default:r(()=>e[11]||(e[11]=[d("Edit")])),_:2},1032,["onClick"])):h("",!0),$.value.btn_delete?(u(),C(_,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:U=>Q(t.id)},{default:r(()=>e[12]||(e[12]=[d("Hapus")])),_:2},1032,["onClick"])):h("",!0),o(_,{class:"ml-2 bg-blue-600 hover:bg-blue-700",onClick:U=>O(t)},{default:r(()=>e[13]||(e[13]=[d("+ Sub")])),_:2},1032,["onClick"])])]))),128))])])]),o(E,{show:k.value,title:c.value?"Edit Kategori":"Tambah Kategori",onClose:y},{content:r(()=>[s("form",{onSubmit:T(z,["prevent"])},[s("div",de,[o(b,{for:"name"},{default:r(()=>e[15]||(e[15]=[d(" Nama Kategori "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(g,{id:"name",modelValue:a(l).name,"onUpdate:modelValue":e[2]||(e[2]=t=>a(l).name=t),class:"block w-full",required:""},null,8,["modelValue"]),o(x,{message:a(l).errors.name},null,8,["message"])]),s("div",ue,[o(b,{for:"description",value:"Deskripsi"}),o(g,{id:"description",modelValue:a(l).description,"onUpdate:modelValue":e[3]||(e[3]=t=>a(l).description=t),class:"block w-full"},null,8,["modelValue"]),o(x,{message:a(l).errors.description},null,8,["message"])]),s("div",me,[A(s("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[4]||(e[4]=t=>a(l).is_active=t),class:"mr-2"},null,512),[[j,a(l).is_active]]),e[16]||(e[16]=s("label",{for:"is_active"},"Aktif",-1))]),s("div",pe,[o(M,{type:"button",onClick:y},{default:r(()=>e[17]||(e[17]=[d("Batal")])),_:1}),o(_,{class:"ml-3",type:"submit"},{default:r(()=>[d(v(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"]),o(E,{show:w.value,title:"Tambah Sub Kategori",onClose:V},{content:r(()=>[s("form",{onSubmit:T(H,["prevent"])},[s("div",ce,[o(b,{for:"category_id"},{default:r(()=>e[18]||(e[18]=[d(" Kategori "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),A(s("select",{id:"category_id","onUpdate:modelValue":e[5]||(e[5]=t=>a(i).category_id=t),class:"block w-full border rounded-md p-2"},[(u(!0),p(F,null,D(m,t=>(u(),p("option",{key:t.id,value:t.id,disabled:!t.is_active},[d(v(t.name)+" ",1),t.is_active?h("",!0):(u(),p("span",ve,"(Tidak Aktif)"))],8,fe))),128))],512),[[R,a(i).category_id]]),o(x,{message:a(i).errors.category_id},null,8,["message"])]),s("div",_e,[o(b,{for:"name"},{default:r(()=>e[19]||(e[19]=[d(" Nama Sub Kategori "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(g,{id:"name",modelValue:a(i).name,"onUpdate:modelValue":e[6]||(e[6]=t=>a(i).name=t),class:"block w-full"},null,8,["modelValue"]),o(x,{message:a(i).errors.name},null,8,["message"])]),s("div",be,[o(b,{for:"description",value:"Deskripsi"}),o(g,{id:"description",modelValue:a(i).description,"onUpdate:modelValue":e[7]||(e[7]=t=>a(i).description=t),class:"block w-full"},null,8,["modelValue"]),o(x,{message:a(i).errors.description},null,8,["message"])]),s("div",ge,[A(s("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[8]||(e[8]=t=>a(i).is_active=t),class:"mr-2"},null,512),[[j,a(i).is_active]]),e[20]||(e[20]=s("label",{for:"is_active"},"Aktif",-1))]),s("div",xe,[o(M,{type:"button",onClick:V},{default:r(()=>e[21]||(e[21]=[d("Batal")])),_:1}),o(_,{class:"ml-3",type:"submit"},{default:r(()=>e[22]||(e[22]=[d("Simpan")])),_:1})])],32)]),_:1},8,["show"])])]),_:1}))}};export{Be as default};
