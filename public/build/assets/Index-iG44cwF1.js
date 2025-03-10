import{z as F,i as C,d as _,j as K,C as U,c as b,o as i,w as r,a as t,b as l,g as m,e as p,f as v,F as j,h as E,t as x,m as T,u as n,l as I,s as L}from"./app-BAsRu4FG.js";import{_ as z}from"./CustomModal-CTaYHw0f.js";import{_ as k}from"./PrimaryButton--d7rAwVm.js";import{_ as V}from"./SecondaryButton-CdNrAfr3.js";import{_ as $}from"./InputLabel-C3zg-Mom.js";import{_ as w}from"./TextInput-BRg-EK8C.js";import{_ as A}from"./InputError-CnX_wM75.js";import{_ as q}from"./AppLayout-BJkIyiEt.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const H={class:"p-4"},O={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},Q={class:"relative"},G={class:"mt-4 overflow-x-auto"},J={class:"min-w-full border bg-white rounded-lg shadow-md"},P={class:"bg-gray-200"},R={key:0,class:"px-4 py-2 text-center"},W={class:"px-4 py-2"},X={class:"px-4 py-2"},Y={class:"px-4 py-2"},Z={class:"px-4 py-2 text-center"},ee={key:0,class:"px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm"},te={key:1,class:"px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm"},se={key:0,class:"px-4 py-2 text-center"},oe={class:"mb-4"},ae={class:"mb-4"},le={class:"flex items-center"},ie={class:"flex justify-end mt-4"},ge={__name:"Index",setup(ne){const d=F([...C().props.categories]),g=_(!1),c=_(!1),y=_(""),u=_(C().props.settings),B=K(()=>d.filter(a=>a.name.toLowerCase().includes(y.value.toLowerCase()))),s=U({...{id:"",name:"",description:"",is_active:!1}}),h=(a,e=null)=>{c.value=a==="edit",c.value&&e?(s.id=e.id,s.name=e.name,s.description=e.description,s.is_active=!!e.is_active):s.reset(),g.value=!0},f=()=>{s.reset(),g.value=!1},N=()=>{c.value?s.put(route("category.update",s.id),{onSuccess:()=>{const a=d.findIndex(e=>e.id===s.id);a!==-1&&(d[a]={...s.data()}),f()}}):s.post(route("category.store"),{onSuccess:a=>{d.unshift(a.props.categories[0]),f()}})},S=a=>{confirm("Apakah Anda yakin ingin menghapus kategori ini?")&&s.delete(route("category.destroy",a),{onSuccess:()=>{const e=d.findIndex(o=>o.id===a);e!==-1&&d.splice(e,1)}})};return(a,e)=>(i(),b(q,{title:"Category"},{default:r(()=>[t("div",H,[t("div",O,[l(k,{onClick:e[0]||(e[0]=o=>h("create"))},{default:r(()=>e[5]||(e[5]=[m("Tambah Kategori")])),_:1}),t("div",Q,[l(w,{modelValue:y.value,"onUpdate:modelValue":e[1]||(e[1]=o=>y.value=o),placeholder:"Cari Kategori...",class:"pl-10 pr-4 py-2 border rounded-md w-64"},null,8,["modelValue"]),e[6]||(e[6]=t("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])]),t("div",G,[t("table",J,[t("thead",P,[t("tr",null,[e[7]||(e[7]=t("th",{class:"px-4 py-2 text-left"},"No",-1)),e[8]||(e[8]=t("th",{class:"px-4 py-2 text-left"},"Nama",-1)),e[9]||(e[9]=t("th",{class:"px-4 py-2 text-left"},"Deskripsi",-1)),e[10]||(e[10]=t("th",{class:"px-4 py-2 text-center"},"Status",-1)),u.value.btn_edit||u.value.btn_delete?(i(),p("th",R,"Aksi")):v("",!0)])]),t("tbody",null,[(i(!0),p(j,null,E(B.value,(o,M)=>(i(),p("tr",{key:o.id,class:"border-b hover:bg-gray-100"},[t("td",W,x(M+1),1),t("td",X,x(o.name),1),t("td",Y,x(o.description||"-"),1),t("td",Z,[o.is_active?(i(),p("span",ee,"Aktif")):(i(),p("span",te,"Tidak Aktif"))]),u.value.btn_edit||u.value.btn_delete?(i(),p("td",se,[u.value.btn_edit?(i(),b(V,{key:0,onClick:D=>h("edit",o)},{default:r(()=>e[11]||(e[11]=[m("Edit")])),_:2},1032,["onClick"])):v("",!0),u.value.btn_delete?(i(),b(k,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:D=>S(o.id)},{default:r(()=>e[12]||(e[12]=[m("Hapus")])),_:2},1032,["onClick"])):v("",!0)])):v("",!0)]))),128))])])]),l(z,{show:g.value,title:c.value?"Edit Kategori":"Tambah Kategori",onClose:f},{content:r(()=>[t("form",{onSubmit:T(N,["prevent"])},[t("div",oe,[l($,{for:"name",value:"Nama Kategori"}),l(w,{id:"name",modelValue:n(s).name,"onUpdate:modelValue":e[2]||(e[2]=o=>n(s).name=o),class:"block w-full",required:""},null,8,["modelValue"]),l(A,{message:n(s).errors.name},null,8,["message"])]),t("div",ae,[l($,{for:"description",value:"Deskripsi"}),l(w,{id:"description",modelValue:n(s).description,"onUpdate:modelValue":e[3]||(e[3]=o=>n(s).description=o),class:"block w-full"},null,8,["modelValue"]),l(A,{message:n(s).errors.description},null,8,["message"])]),t("div",le,[I(t("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":e[4]||(e[4]=o=>n(s).is_active=o),class:"mr-2"},null,512),[[L,n(s).is_active]]),e[13]||(e[13]=t("label",{for:"is_active"},"Aktif",-1))]),t("div",ie,[l(V,{type:"button",onClick:f},{default:r(()=>e[14]||(e[14]=[m("Batal")])),_:1}),l(k,{class:"ml-3",type:"submit"},{default:r(()=>[m(x(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{ge as default};
