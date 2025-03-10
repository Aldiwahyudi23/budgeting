import{i as T,d as i,j as N,C as Q,k as q,c as F,o as l,w as p,a as s,e as d,f as m,b as r,t as u,g as v,l as c,F as g,h as _,u as a,v as C,m as X,p as R,W as Z}from"./app-BAsRu4FG.js";import{_ as ee}from"./AppLayout-BJkIyiEt.js";import{_ as P}from"./PrimaryButton--d7rAwVm.js";import{_ as I}from"./SecondaryButton-CdNrAfr3.js";import{_ as y}from"./InputLabel-C3zg-Mom.js";import{_ as B}from"./TextInput-BRg-EK8C.js";import{_ as b}from"./InputError-CnX_wM75.js";import{_ as te}from"./CustomModal-CTaYHw0f.js";import{h as se}from"./sweetalert-DN_NdTnD.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const oe={class:"p-4"},ae={key:0,class:"bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"},le={key:1,class:"bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"},ne={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},re={class:"flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto"},de={class:"flex items-center space-x-4 w-full md:w-auto"},ue={class:"flex-1 md:flex-none"},ie=["value"],pe={class:"flex-1 md:flex-none"},me=["value"],ce={class:"relative w-full md:w-64"},ge={class:"mt-4 overflow-x-auto"},_e={class:"min-w-full border bg-white rounded-lg shadow-md"},fe={class:"px-4 py-2"},ve={class:"px-4 py-2"},ye={class:"px-4 py-2"},be={class:"px-4 py-2"},xe={class:"px-4 py-2"},ke={class:"px-4 py-2"},he={class:"px-4 py-2"},we={class:"px-4 py-2 text-center"},Ce={class:"mb-4"},Se={class:"mb-4"},Ve={class:"mb-4"},$e=["value"],Me={class:"mb-4"},Ae=["disabled"],Ue=["value"],De={class:"mb-4"},Te={class:"flex space-x-4 mt-2"},Fe={class:"flex items-center"},Pe={class:"flex items-center"},Be={key:0,class:"mb-4"},Ee={value:""},Ke={key:0},Le={label:"Rekening"},Ne=["value"],Re={key:0,label:"Sub Kategori (Saving)"},Ie=["value"],Je={class:"flex justify-end mt-4"},Ze={__name:"Index",props:{expenses:Array,categories:Array,subCategories:Array,accountBanks:Array},setup(M){const E=T();console.log(E.props.flash),se(E);const S=M,x=i(""),A=i(!1),k=i(!1),h=i(T().props.settings),K=i(T().props.savingSubCategories),J=Array.from({length:6},(n,e)=>2025+e),j=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],U=i(new Date().getFullYear()),D=i(new Date().getMonth()+1),Y=N(()=>S.expenses.filter(n=>{var w;const e=new Date(n.date),t=e.getFullYear()===U.value,f=e.getMonth()+1===D.value,$=n.category.name.toLowerCase().includes(x.value.toLowerCase())||((w=n.sub_category)==null?void 0:w.name.toLowerCase().includes(x.value.toLowerCase()))||n.payment.toLowerCase().includes(x.value.toLowerCase());return t&&f&&$})),O=N(()=>S.subCategories.filter(n=>n.category_id===o.category_id)),W=n=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(n),o=Q({id:"",date:"",amount:"",category_id:"",sub_kategori_id:null,payment:"",account_id:null}),L=(n,e=null)=>{k.value=n==="edit",k.value&&e?(o.id=e.id,o.date=e.date,o.amount=e.amount,o.category_id=e.category_id,o.sub_kategori_id=e.sub_kategori_id,o.payment=e.payment,o.account_id=e.account_id):o.reset(),A.value=!0},V=()=>{o.reset(),A.value=!1},z=()=>{k.value?o.put(route("expense.update",o.id),{onSuccess:()=>V()}):o.post(route("expense.store"),{onSuccess:()=>V()})},G=n=>{confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")&&Z.delete(route("expense.destroy",n),{onSuccess:()=>{const e=S.expenses.findIndex(t=>t.id===n);e!==-1&&S.expenses.splice(e,1)},onError:e=>{alert("Gagal menghapus pengeluaran. Silakan coba lagi.")}})};return q(()=>{h.value.saving_expense&&console.log(K.value)}),(n,e)=>(l(),F(ee,{title:"Expenses"},{default:p(()=>[s("div",oe,[n.$page.props.flash.success?(l(),d("div",ae,u(n.$page.props.flash.success),1)):m("",!0),n.$page.props.flash.error?(l(),d("div",le,u(n.$page.props.flash.error),1)):m("",!0),s("div",ne,[r(P,{onClick:e[0]||(e[0]=t=>L("create"))},{default:p(()=>e[14]||(e[14]=[v("Tambah Pengeluaran")])),_:1}),s("div",re,[s("div",de,[e[15]||(e[15]=s("span",{class:"text-sm font-medium text-gray-700"},"Filter:",-1)),s("div",ue,[c(s("select",{id:"year","onUpdate:modelValue":e[1]||(e[1]=t=>U.value=t),class:"block w-full border rounded-md p-2"},[(l(!0),d(g,null,_(a(J),t=>(l(),d("option",{key:t,value:t},u(t),9,ie))),128))],512),[[C,U.value]])]),s("div",pe,[c(s("select",{id:"month","onUpdate:modelValue":e[2]||(e[2]=t=>D.value=t),class:"block w-full border rounded-md p-2"},[(l(),d(g,null,_(j,(t,f)=>s("option",{key:f,value:f+1},u(t),9,me)),64))],512),[[C,D.value]])])]),s("div",ce,[r(B,{modelValue:x.value,"onUpdate:modelValue":e[3]||(e[3]=t=>x.value=t),placeholder:"Cari Pemasukan...",class:"pl-10 pr-4 py-2 border rounded-md w-full"},null,8,["modelValue"]),e[16]||(e[16]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])])]),s("div",ge,[s("table",_e,[e[19]||(e[19]=s("thead",{class:"bg-gray-200"},[s("tr",null,[s("th",{class:"px-4 py-2 text-left"},"No"),s("th",{class:"px-4 py-2 text-left"},"Tanggal"),s("th",{class:"px-4 py-2 text-left"},"Jumlah"),s("th",{class:"px-4 py-2 text-left"},"Kategori"),s("th",{class:"px-4 py-2 text-left"},"Sub Kategori"),s("th",{class:"px-4 py-2 text-left"},"Pembayaran"),s("th",{class:"px-4 py-2 text-left"},"Rekening"),s("th",{class:"px-4 py-2 text-center"},"Aksi")])],-1)),s("tbody",null,[(l(!0),d(g,null,_(Y.value,(t,f)=>{var $,w;return l(),d("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",fe,u(f+1),1),s("td",ve,u(t.date),1),s("td",ye,u(W(t.amount)),1),s("td",be,u(t.category.name),1),s("td",xe,u((($=t.sub_category)==null?void 0:$.name)||"-"),1),s("td",ke,u(t.payment),1),s("td",he,u(((w=t.account_bank)==null?void 0:w.name)||"-"),1),s("td",we,[h.value.btn_edit?(l(),F(I,{key:0,onClick:H=>L("edit",t)},{default:p(()=>e[17]||(e[17]=[v("Edit")])),_:2},1032,["onClick"])):m("",!0),h.value.btn_delete?(l(),F(P,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:H=>G(t.id)},{default:p(()=>e[18]||(e[18]=[v("Hapus")])),_:2},1032,["onClick"])):m("",!0)])])}),128))])])]),r(te,{show:A.value,title:k.value?"Edit Pengeluaran":"Tambah Pengeluaran",onClose:V},{content:p(()=>[s("form",{onSubmit:X(z,["prevent"])},[s("div",Ce,[r(y,{for:"date",value:"Tanggal"}),r(B,{id:"date",type:"date",modelValue:a(o).date,"onUpdate:modelValue":e[4]||(e[4]=t=>a(o).date=t),class:"block w-full"},null,8,["modelValue"]),r(b,{message:a(o).errors.date},null,8,["message"])]),s("div",Se,[r(y,{for:"amount",value:"Jumlah"}),r(B,{id:"amount",type:"number",modelValue:a(o).amount,"onUpdate:modelValue":e[5]||(e[5]=t=>a(o).amount=t),class:"block w-full"},null,8,["modelValue"]),r(b,{message:a(o).errors.amount},null,8,["message"])]),s("div",Ve,[r(y,{for:"category_id",value:"Kategori"}),c(s("select",{id:"category_id","onUpdate:modelValue":e[6]||(e[6]=t=>a(o).category_id=t),class:"block w-full border rounded-md p-2",onChange:e[7]||(e[7]=t=>a(o).sub_kategori_id=null)},[e[20]||(e[20]=s("option",{value:""},"Pilih Kategori",-1)),(l(!0),d(g,null,_(M.categories,t=>(l(),d("option",{key:t.id,value:t.id},u(t.name),9,$e))),128))],544),[[C,a(o).category_id]]),r(b,{message:a(o).errors.category_id},null,8,["message"])]),s("div",Me,[r(y,{for:"sub_kategori_id",value:"Sub Kategori"}),c(s("select",{id:"sub_kategori_id","onUpdate:modelValue":e[8]||(e[8]=t=>a(o).sub_kategori_id=t),class:"block w-full border rounded-md p-2",disabled:!a(o).category_id},[e[21]||(e[21]=s("option",{value:""},"Pilih Sub Kategori",-1)),(l(!0),d(g,null,_(O.value,t=>(l(),d("option",{key:t.id,value:t.id},u(t.name),9,Ue))),128))],8,Ae),[[C,a(o).sub_kategori_id]]),r(b,{message:a(o).errors.sub_kategori_id},null,8,["message"])]),s("div",De,[r(y,{for:"payment",value:"Pembayaran"}),s("div",Te,[s("label",Fe,[c(s("input",{type:"radio","onUpdate:modelValue":e[9]||(e[9]=t=>a(o).payment=t),value:"Transfer",class:"mr-2",onChange:e[10]||(e[10]=t=>a(o).account_id="")},null,544),[[R,a(o).payment]]),e[22]||(e[22]=s("span",null,"Transfer",-1))]),s("label",Pe,[c(s("input",{type:"radio","onUpdate:modelValue":e[11]||(e[11]=t=>a(o).payment=t),value:"Tunai",class:"mr-2",onChange:e[12]||(e[12]=t=>a(o).account_id=null)},null,544),[[R,a(o).payment]]),e[23]||(e[23]=s("span",null,"Tunai",-1))])]),r(b,{message:a(o).errors.payment},null,8,["message"])]),a(o).payment==="Transfer"?(l(),d("div",Be,[r(y,{for:"account_id",value:"Sumber Rekening "}),c(s("select",{id:"account_id","onUpdate:modelValue":e[13]||(e[13]=t=>a(o).account_id=t),class:"block w-full border rounded-md p-2"},[s("option",Ee,[e[24]||(e[24]=v(" Pilih Rekening ")),h.value.saving_expense?(l(),d("span",Ke," atau Data Saving")):m("",!0)]),s("optgroup",Le,[(l(!0),d(g,null,_(M.accountBanks,t=>(l(),d("option",{key:t.id,value:`account_${t.id}`},u(t.name),9,Ne))),128))]),h.value.saving_expense?(l(),d("optgroup",Re,[(l(!0),d(g,null,_(K.value,t=>(l(),d("option",{key:t.id,value:`subcategory_${t.id}`},u(t.name),9,Ie))),128))])):m("",!0)],512),[[C,a(o).account_id]]),r(b,{message:a(o).errors.account_id},null,8,["message"])])):m("",!0),s("div",Je,[r(I,{type:"button",onClick:V},{default:p(()=>e[25]||(e[25]=[v("Batal")])),_:1}),r(P,{class:"ml-3",type:"submit"},{default:p(()=>[v(u(k.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{Ze as default};
