import{d as f,i as L,C as F,j as z,c as k,o as l,w as d,a as s,b as a,g as p,l as w,e as i,F as h,h as S,t as u,v as B,f as _,m as H,u as r,s as O}from"./app-DAhUBfNg.js";import{A as Q}from"./AppLayout-B9YO4Fio.js";import{_ as q}from"./CustomModal-CiEaeTYu.js";import{_ as V}from"./PrimaryButton-CH66qtZZ.js";import{_ as M}from"./SecondaryButton-BmdcTKXT.js";import{_ as A}from"./InputLabel-CXVA5cC8.js";import{_ as C}from"./TextInput-Dfffom07.js";import{_ as $}from"./InputError-DNhYr1Wq.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const G={class:"p-4"},I={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},J={class:"flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto"},P=["value"],R={class:"relative"},W={class:"mt-4 overflow-x-auto"},X={class:"min-w-full border bg-white rounded-lg shadow-md"},Y={class:"bg-gray-200"},Z={key:0,class:"px-4 py-2 text-center"},ee={class:"px-4 py-2"},te={class:"px-4 py-2"},se={class:"px-4 py-2"},oe={class:"px-4 py-2"},le={class:"px-4 py-2 text-center"},ae={key:0,class:"px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm"},ie={key:1,class:"px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm"},re={key:0,class:"px-4 py-2 text-center"},ne={class:"mb-4"},de=["value","disabled"],ue={key:0},me={class:"mb-4"},pe={class:"mb-4"},ce={class:"flex items-center"},fe={class:"flex justify-end mt-4"},Se={__name:"Sub",props:{subCategory:Array,category:Array},setup(N){const x=N,b=f(!1),c=f(!1),m=f(L().props.settings),o=F({id:null,category_id:"",name:"",description:"",is_active:!1}),v=f(""),g=f(""),U=z(()=>x.subCategory.filter(n=>{const e=v.value?n.category_id===v.value:!0,t=n.name.toLowerCase().includes(g.value.toLowerCase());return e&&t})),K=(n,e=null)=>{c.value=n==="edit",c.value&&e?(o.id=e.id,o.category_id=e.category_id,o.name=e.name,o.description=e.description,o.is_active=!!e.is_active):o.reset(),b.value=!0},y=()=>{o.reset(),b.value=!1},D=()=>{c.value?o.put(route("sub-category.update",o.id),{onSuccess:()=>y()}):o.post(route("sub-category.store"),{onSuccess:()=>y()})},T=n=>{confirm("Apakah Anda yakin ingin menghapus sub kategori ini?")&&o.delete(route("sub-category.destroy",n))};return(n,e)=>(l(),k(Q,{title:"Sub Category"},{default:d(()=>[s("div",G,[s("div",I,[a(V,{onClick:e[0]||(e[0]=t=>K("create"))},{default:d(()=>e[7]||(e[7]=[p("Tambah Sub Kategori")])),_:1}),s("div",J,[w(s("select",{"onUpdate:modelValue":e[1]||(e[1]=t=>v.value=t),class:"border rounded px-4 py-2 w-full md:w-48"},[e[8]||(e[8]=s("option",{value:""},"Semua Kategori",-1)),(l(!0),i(h,null,S(x.category,t=>(l(),i("option",{key:t.id,value:t.id},u(t.name),9,P))),128))],512),[[B,v.value]]),s("div",R,[a(C,{modelValue:g.value,"onUpdate:modelValue":e[2]||(e[2]=t=>g.value=t),placeholder:"Cari Sub Kategori...",class:"w-full md:w-48 pl-10 pr-4 py-2 border"},null,8,["modelValue"]),e[9]||(e[9]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])])]),s("div",W,[s("table",X,[s("thead",Y,[s("tr",null,[e[10]||(e[10]=s("th",{class:"px-4 py-2 text-left"},"No",-1)),e[11]||(e[11]=s("th",{class:"px-4 py-2 text-left"},"Kategori",-1)),e[12]||(e[12]=s("th",{class:"px-4 py-2 text-left"},"Nama",-1)),e[13]||(e[13]=s("th",{class:"px-4 py-2 text-left"},"Deskripsi",-1)),e[14]||(e[14]=s("th",{class:"px-4 py-2 text-center"},"Status",-1)),m.value.btn_edit||m.value.btn_delete?(l(),i("th",Z,"Aksi")):_("",!0)])]),s("tbody",null,[(l(!0),i(h,null,S(U.value,(t,j)=>(l(),i("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",ee,u(j+1),1),s("td",te,u(t.category.name),1),s("td",se,u(t.name),1),s("td",oe,u(t.description||"-"),1),s("td",le,[t.is_active?(l(),i("span",ae,"Aktif")):(l(),i("span",ie,"Tidak Aktif"))]),m.value.btn_edit||m.value.btn_delete?(l(),i("td",re,[m.value.btn_edit?(l(),k(M,{key:0,onClick:E=>K("edit",t)},{default:d(()=>e[15]||(e[15]=[p("Edit")])),_:2},1032,["onClick"])):_("",!0),m.value.btn_delete?(l(),k(V,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:E=>T(t.id)},{default:d(()=>e[16]||(e[16]=[p("Hapus")])),_:2},1032,["onClick"])):_("",!0)])):_("",!0)]))),128))])])]),a(q,{show:b.value,title:c.value?"Edit Sub Kategori":"Tambah Sub Kategori",onClose:y},{content:d(()=>[s("form",{onSubmit:H(D,["prevent"])},[s("div",ne,[a(A,{for:"category_id",value:"Kategori"}),w(s("select",{id:"category_id","onUpdate:modelValue":e[3]||(e[3]=t=>r(o).category_id=t),class:"block w-full border rounded-md p-2"},[(l(!0),i(h,null,S(x.category,t=>(l(),i("option",{key:t.id,value:t.id,disabled:!t.is_active},[p(u(t.name)+" ",1),t.is_active?_("",!0):(l(),i("span",ue,"(Tidak Aktif)"))],8,de))),128))],512),[[B,r(o).category_id]]),a($,{message:r(o).errors.category_id},null,8,["message"])]),s("div",me,[a(A,{for:"name",value:"Nama Sub Kategori"}),a(C,{id:"name",modelValue:r(o).name,"onUpdate:modelValue":e[4]||(e[4]=t=>r(o).name=t),class:"block w-full"},null,8,["modelValue"]),a($,{message:r(o).errors.name},null,8,["message"])]),s("div",pe,[a(A,{for:"description",value:"Deskripsi"}),a(C,{id:"description",modelValue:r(o).description,"onUpdate:modelValue":e[5]||(e[5]=t=>r(o).description=t),class:"block w-full"},null,8,["modelValue"]),a($,{message:r(o).errors.description},null,8,["message"])]),s("div",ce,[w(s("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[6]||(e[6]=t=>r(o).is_active=t),class:"mr-2"},null,512),[[O,r(o).is_active]]),e[17]||(e[17]=s("label",{for:"is_active"},"Aktif",-1))]),s("div",fe,[a(M,{type:"button",onClick:y},{default:d(()=>e[18]||(e[18]=[p("Batal")])),_:1}),a(V,{class:"ml-3",type:"submit"},{default:d(()=>[p(u(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{Se as default};
