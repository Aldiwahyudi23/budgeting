import{i as N,d as f,j as k,C as te,k as se,l as ae,m as oe,c as E,o as n,w as p,a as s,e as l,f as m,b as d,t as i,g as u,p as _,F as b,h as v,u as r,v as V,q as ne,s as Y,W as le}from"./app-CeecCbUL.js";import{A as re}from"./AppLayout-CDav98qo.js";import{_ as F}from"./PrimaryButton-DB6cx0Ms.js";import{_ as J}from"./SecondaryButton-5uXxFE6E.js";import{_ as w}from"./InputLabel-CAVvzARx.js";import{_ as L}from"./TextInput-CX7szSky.js";import{_ as C}from"./InputError-C7a1NDCw.js";import{_ as de}from"./CustomModal-BOTcBan0.js";import{_ as ie}from"./_plugin-vue_export-helper-DlAUqK2U.js";const ue={class:"p-4"},pe={key:0,class:"bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"},me={key:1,class:"bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"},ge={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},ce={class:"flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto"},fe={class:"flex items-center space-x-4 w-full md:w-auto"},_e={class:"flex-1 md:flex-none"},be=["value"],ve={class:"flex-1 md:flex-none"},ye=["value"],xe={class:"relative w-full md:w-64"},ke={class:"mt-4 overflow-x-auto"},we={class:"min-w-full border bg-white rounded-lg shadow-md"},Ce={class:"bg-gray-200"},he={key:0,class:"px-4 py-2 text-center"},Ae={class:"px-4 py-2"},Ve={class:"px-4 py-2"},Se={class:"px-4 py-2"},Te={class:"px-4 py-2"},$e={class:"px-4 py-2"},Me={class:"px-4 py-2"},Be={class:"px-4 py-2"},De={key:0,class:"px-4 py-2 text-center"},Ue={class:"mb-4"},Ie={class:"mb-4"},Ne=["value","disabled"],Ee={key:0},Fe={class:"mb-4"},Le=["disabled"],Pe=["value","disabled"],Ke={key:0},Re={class:"mb-4"},je={class:"mb-4"},Ye={class:"flex space-x-4 mt-2"},Je={class:"flex items-center"},qe={key:0,class:"flex items-center"},He={key:0,class:"mb-4"},Oe={label:"Rekening"},We=["value","disabled"],ze={key:0},Ge={key:0,label:"Saving (Tabungan)"},Qe=["value","disabled"],Xe={key:0},Ze={class:"flex justify-end mt-4"},et={__name:"Index",props:{expenses:Array,categories:Array,subCategories:Array,accountBanks:Array,bills:Array,debts:Array},setup($){const g=$;N();const y=f(""),M=f(!1),h=f(!1),c=f(N().props.settings),P=f(N().props.savingSubCategories),q=Array.from({length:6},(o,e)=>2025+e),H=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],B=f(new Date().getFullYear()),D=f(new Date().getMonth()+1),O=k(()=>g.expenses.filter(o=>{var A;const e=new Date(o.date),t=e.getFullYear()===B.value,x=e.getMonth()+1===D.value,T=y.value?o.category.name.toLowerCase().includes(y.value.toLowerCase())||((A=o.sub_category)==null?void 0:A.name.toLowerCase().includes(y.value.toLowerCase()))||o.payment.toLowerCase().includes(y.value.toLowerCase()):!0;return t&&x&&T})),a=te({id:"",date:"",amount:"",category_id:"",sub_kategori_id:null,payment:"",account_id:null}),W=k(()=>g.subCategories.filter(o=>o.category_id===a.category_id)),U=o=>o?new Intl.NumberFormat("id-ID").format(o):"",z=o=>o?o.replace(/\./g,""):"",I=k({get:()=>U(a.amount),set:o=>{a.amount=z(o)}});se(()=>{I.value=U(a.amount)});const K=k(()=>{const o=g.categories.find(e=>e.id===a.category_id);return o&&o.name==="Saving (Tabungan)"}),G=k(()=>{const o=g.categories.find(e=>e.id===a.category_id);return o&&o.name==="Bills (Tagihan)"}),Q=k(()=>{const o=g.categories.find(e=>e.id===a.category_id);return o&&o.name==="Debt (Hutang)"}),R=()=>{if(G.value&&a.sub_kategori_id){const o=g.bills.find(e=>e.sub_category_id===a.sub_kategori_id);a.amount=o?o.amount:""}if(Q.value&&a.sub_kategori_id){const o=g.debts.find(e=>e.sub_category_id===a.sub_kategori_id);a.amount=o?o.amount:""}};ae(()=>a.sub_kategori_id,o=>{o&&R()});const j=(o,e=null)=>{h.value=o==="edit",h.value&&e?(a.id=e.id,a.date=e.date,a.amount=e.amount,a.category_id=e.category_id,a.sub_kategori_id=e.sub_kategori_id,a.payment=e.payment,a.account_id=e.account_id):a.reset(),M.value=!0},S=()=>{a.reset(),M.value=!1},X=()=>{h.value?a.put(route("expense.update",a.id),{onSuccess:()=>S()}):a.post(route("expense.store"),{onSuccess:()=>S()})},Z=o=>{confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")&&le.delete(route("expense.destroy",o),{onSuccess:()=>{const e=g.expenses.findIndex(t=>t.id===o);e!==-1&&g.expenses.splice(e,1)},onError:()=>{alert("Gagal menghapus pengeluaran. Silakan coba lagi.")}})};return oe(()=>{c.value.saving_expense&&console.log(P.value)}),(o,e)=>(n(),E(re,{title:"Expenses"},{default:p(()=>[s("div",ue,[o.$page.props.flash.success?(n(),l("div",pe,i(o.$page.props.flash.success),1)):m("",!0),o.$page.props.flash.error?(n(),l("div",me,i(o.$page.props.flash.error),1)):m("",!0),s("div",ge,[d(F,{onClick:e[0]||(e[0]=t=>j("create"))},{default:p(()=>e[14]||(e[14]=[u("Tambah Pengeluaran")])),_:1}),s("div",ce,[s("div",fe,[e[15]||(e[15]=s("span",{class:"text-sm font-medium text-gray-700"},"Filter:",-1)),s("div",_e,[_(s("select",{id:"year","onUpdate:modelValue":e[1]||(e[1]=t=>B.value=t),class:"block w-full border rounded-md p-2"},[(n(!0),l(b,null,v(r(q),t=>(n(),l("option",{key:t,value:t},i(t),9,be))),128))],512),[[V,B.value]])]),s("div",ve,[_(s("select",{id:"month","onUpdate:modelValue":e[2]||(e[2]=t=>D.value=t),class:"block w-full border rounded-md p-2"},[(n(),l(b,null,v(H,(t,x)=>s("option",{key:x,value:x+1},i(t),9,ye)),64))],512),[[V,D.value]])])]),s("div",xe,[d(L,{modelValue:y.value,"onUpdate:modelValue":e[3]||(e[3]=t=>y.value=t),placeholder:"Cari...",class:"pl-10 pr-4 py-2 border rounded-md w-full"},null,8,["modelValue"]),e[16]||(e[16]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])])]),s("div",ke,[s("table",we,[s("thead",Ce,[s("tr",null,[e[17]||(e[17]=s("th",{class:"px-4 py-2 text-left"},"No",-1)),e[18]||(e[18]=s("th",{class:"px-4 py-2 text-left"},"Tanggal",-1)),e[19]||(e[19]=s("th",{class:"px-4 py-2 text-left"},"Nominal",-1)),e[20]||(e[20]=s("th",{class:"px-4 py-2 text-left"},"Kategori",-1)),e[21]||(e[21]=s("th",{class:"px-4 py-2 text-left"},"Keterangan",-1)),e[22]||(e[22]=s("th",{class:"px-4 py-2 text-left"},"Pembayaran",-1)),e[23]||(e[23]=s("th",{class:"px-4 py-2 text-left"},"Rekening",-1)),c.value.btn_edit||c.value.btn_delete?(n(),l("th",he,"Aksi")):m("",!0)])]),s("tbody",null,[(n(!0),l(b,null,v(O.value,(t,x)=>{var T,A;return n(),l("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",Ae,i(x+1),1),s("td",Ve,i(t.date),1),s("td",Se,i(U(t.amount)),1),s("td",Te,i(t.category.name),1),s("td",$e,i(((T=t.sub_category)==null?void 0:T.name)||"-"),1),s("td",Me,i(t.payment),1),s("td",Be,i(((A=t.account_bank)==null?void 0:A.name)||"-"),1),c.value.btn_edit||c.value.btn_delete?(n(),l("td",De,[c.value.btn_edit?(n(),E(J,{key:0,onClick:ee=>j("edit",t)},{default:p(()=>e[24]||(e[24]=[u("Edit")])),_:2},1032,["onClick"])):m("",!0),c.value.btn_delete?(n(),E(F,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:ee=>Z(t.id)},{default:p(()=>e[25]||(e[25]=[u("Hapus")])),_:2},1032,["onClick"])):m("",!0)])):m("",!0)])}),128))])])]),d(de,{show:M.value,title:h.value?"Edit Pengeluaran":"Tambah Pengeluaran",onClose:S},{content:p(()=>[s("form",{onSubmit:ne(X,["prevent"])},[s("div",Ue,[d(w,{for:"date"},{default:p(()=>e[26]||(e[26]=[u(" Tanggal "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),d(L,{id:"date",type:"date",modelValue:r(a).date,"onUpdate:modelValue":e[4]||(e[4]=t=>r(a).date=t),class:"block w-full"},null,8,["modelValue"]),d(C,{message:r(a).errors.date},null,8,["message"])]),s("div",Ie,[d(w,{for:"category_id"},{default:p(()=>e[27]||(e[27]=[u(" Kategori "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"category_id","onUpdate:modelValue":e[5]||(e[5]=t=>r(a).category_id=t),class:"block w-full border rounded-md p-2",onChange:e[6]||(e[6]=(...t)=>o.onCategoryChange&&o.onCategoryChange(...t))},[e[28]||(e[28]=s("option",{disabled:"",value:""},"Pilih Kategori",-1)),(n(!0),l(b,null,v($.categories,t=>(n(),l("option",{key:t.id,value:t.id,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Ee,"(Tidak Aktif)"))],8,Ne))),128))],544),[[V,r(a).category_id]]),d(C,{message:r(a).errors.category_id},null,8,["message"])]),s("div",Fe,[d(w,{for:"sub_kategori_id"},{default:p(()=>e[29]||(e[29]=[u(" Keterangan "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"sub_kategori_id","onUpdate:modelValue":e[7]||(e[7]=t=>r(a).sub_kategori_id=t),class:"block w-full border rounded-md p-2",disabled:!r(a).category_id,onChange:R},[e[30]||(e[30]=s("option",{disabled:"",value:""},"Pilih Keterangan",-1)),(n(!0),l(b,null,v(W.value,t=>(n(),l("option",{key:t.id,value:t.id,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Ke,"(Tidak Aktif)"))],8,Pe))),128))],40,Le),[[V,r(a).sub_kategori_id]]),d(C,{message:r(a).errors.sub_kategori_id},null,8,["message"])]),s("div",Re,[d(w,{for:"amount"},{default:p(()=>e[31]||(e[31]=[u(" Nominal "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),d(L,{id:"amount",type:"text",modelValue:I.value,"onUpdate:modelValue":e[8]||(e[8]=t=>I.value=t),onInput:o.handleAmountInput,class:"block w-full"},null,8,["modelValue","onInput"]),d(C,{message:r(a).errors.amount},null,8,["message"])]),s("div",je,[d(w,{for:"payment"},{default:p(()=>e[32]||(e[32]=[u(" Pembayaran "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),s("div",Ye,[s("label",Je,[_(s("input",{type:"radio","onUpdate:modelValue":e[9]||(e[9]=t=>r(a).payment=t),value:"Transfer",class:"mr-2",onChange:e[10]||(e[10]=t=>r(a).account_id="")},null,544),[[Y,r(a).payment]]),e[33]||(e[33]=s("span",null,"Transfer",-1))]),K.value?m("",!0):(n(),l("label",qe,[_(s("input",{type:"radio","onUpdate:modelValue":e[11]||(e[11]=t=>r(a).payment=t),value:"Tunai",class:"mr-2",onChange:e[12]||(e[12]=t=>r(a).account_id=null)},null,544),[[Y,r(a).payment]]),e[34]||(e[34]=s("span",null,"Tunai",-1))]))]),d(C,{message:r(a).errors.payment},null,8,["message"])]),r(a).payment==="Transfer"?(n(),l("div",He,[d(w,{for:"account_id"},{default:p(()=>e[35]||(e[35]=[u(" Sumber Rekening "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"account_id","onUpdate:modelValue":e[13]||(e[13]=t=>r(a).account_id=t),class:"block w-full border rounded-md p-2",required:""},[e[36]||(e[36]=s("option",{disabled:"",value:""},"Pilih Rekening",-1)),s("optgroup",Oe,[(n(!0),l(b,null,v($.accountBanks,t=>(n(),l("option",{key:t.id,value:`account_${t.id}`,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",ze,"(Tidak Aktif)"))],8,We))),128))]),!K.value&&c.value.saving_expense?(n(),l("optgroup",Ge,[(n(!0),l(b,null,v(P.value,t=>(n(),l("option",{key:t.id,value:`subcategory_${t.id}`,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Xe,"(Tidak Aktif)"))],8,Qe))),128))])):m("",!0)],512),[[V,r(a).account_id]]),d(C,{message:r(a).errors.account_id},null,8,["message"])])):m("",!0),s("div",Ze,[d(J,{type:"button",onClick:S},{default:p(()=>e[37]||(e[37]=[u("Batal")])),_:1}),d(F,{class:"ml-3",type:"submit"},{default:p(()=>[u(i(h.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}},ut=ie(et,[["__scopeId","data-v-4b5ebbf6"]]);export{ut as default};
