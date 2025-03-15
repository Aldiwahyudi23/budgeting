import{i as I,d as f,j,k,C as oe,l as ne,m as le,c as N,o as n,w as p,a as s,e as l,f as m,b as d,t as i,g as u,p as _,F as v,h as b,v as T,q as re,u as r,s as O,W as J}from"./app-BAOndlI2.js";import{A as de}from"./AppLayout-BudElh9R.js";import{_ as E}from"./PrimaryButton-mjiLLIlT.js";import{_ as q}from"./SecondaryButton-CurAdCmn.js";import{_ as w}from"./InputLabel-BJhzS3hS.js";import{_ as L}from"./TextInput-BitYVA7p.js";import{_ as C}from"./InputError-BYa4BhiO.js";import{_ as ie}from"./CustomModal-Dr3Fy5f8.js";import{_ as ue}from"./_plugin-vue_export-helper-DlAUqK2U.js";const pe={class:"p-4"},me={key:0,class:"bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"},ce={key:1,class:"bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"},ge={class:"flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0"},fe={class:"flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto"},_e={class:"flex items-center space-x-4 w-full md:w-auto"},ve={class:"flex-1 md:flex-none"},be=["value"],ye={class:"flex-1 md:flex-none"},xe=["value"],ke={class:"relative w-full md:w-64"},we={class:"mt-4 overflow-x-auto"},Ce={class:"min-w-full border bg-white rounded-lg shadow-md"},he={class:"bg-gray-200"},Ae={key:0,class:"px-4 py-2 text-center"},Se={class:"px-4 py-2"},Ve={class:"px-4 py-2"},Te={class:"px-4 py-2"},$e={class:"px-4 py-2"},De={class:"px-4 py-2"},Me={class:"px-4 py-2"},Be={class:"px-4 py-2"},Ue={key:0,class:"px-4 py-2 text-center"},Fe={class:"mb-4"},Ie={class:"mb-4"},Ne=["value","disabled"],Ee={key:0},Le={class:"mb-4"},Pe=["disabled"],Ke=["value","disabled"],Re={key:0},Ye={class:"mb-4"},je={class:"mb-4"},Oe={class:"flex space-x-4 mt-2"},Je={class:"flex items-center"},qe={key:0,class:"flex items-center"},He={key:0,class:"mb-4"},We={label:"Rekening"},ze=["value","disabled"],Ge={key:0},Qe={key:0,label:"Saving (Tabungan)"},Xe=["value","disabled"],Ze={key:0},et={class:"flex justify-end mt-4"},tt={__name:"IndexOri",props:{expenses:Array,categories:Array,subCategories:Array,accountBanks:Array,bills:Array,debts:Array},setup(M){const c=M;I();const y=f(""),B=f(!1),h=f(!1),g=f(I().props.settings),P=f(I().props.savingSubCategories),H=f(Array.from({length:10},(a,e)=>new Date().getFullYear()-e)),W=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],A=f(new Date().getFullYear()),S=f(new Date().getMonth()+1),z=()=>{const a={year:A.value,month:S.value};J.get(route("expense.index"),a,{preserveState:!0,replace:!0})};j([A,S],()=>{z()});const G=k(()=>c.expenses.filter(a=>{var V;const e=new Date(a.date),t=e.getFullYear()===A.value,x=e.getMonth()+1===S.value,D=y.value?a.category.name.toLowerCase().includes(y.value.toLowerCase())||((V=a.sub_category)==null?void 0:V.name.toLowerCase().includes(y.value.toLowerCase()))||a.payment.toLowerCase().includes(y.value.toLowerCase()):!0;return t&&x&&D})),o=oe({id:"",date:"",amount:"",category_id:"",sub_kategori_id:null,payment:"",account_id:null}),Q=k(()=>c.subCategories.filter(a=>a.category_id===o.category_id)),U=a=>a?new Intl.NumberFormat("id-ID").format(a):"",X=a=>a?a.replace(/\./g,""):"",F=k({get:()=>U(o.amount),set:a=>{o.amount=X(a)}});ne(()=>{F.value=U(o.amount)});const K=k(()=>{const a=c.categories.find(e=>e.id===o.category_id);return a&&a.name==="Saving (Tabungan)"}),Z=k(()=>{const a=c.categories.find(e=>e.id===o.category_id);return a&&a.name==="Bills (Tagihan)"}),ee=k(()=>{const a=c.categories.find(e=>e.id===o.category_id);return a&&a.name==="Debt (Hutang)"}),R=()=>{if(Z.value&&o.sub_kategori_id){const a=c.bills.find(e=>e.sub_category_id===o.sub_kategori_id);console.log("Selected Bill:",a),o.amount=a?a.amount:""}if(ee.value&&o.sub_kategori_id){const a=c.debts.find(e=>e.sub_category_id===o.sub_kategori_id);console.log("Selected Debt:",a),o.amount=a?a.amount:""}};j(()=>o.sub_kategori_id,a=>{a&&R()});const Y=(a,e=null)=>{h.value=a==="edit",h.value&&e?(o.id=e.id,o.date=e.date,o.amount=e.amount,o.category_id=e.category_id,o.sub_kategori_id=e.sub_kategori_id,o.payment=e.payment,o.account_id=e.account_id):o.reset(),B.value=!0},$=()=>{o.reset(),B.value=!1},te=()=>{h.value?o.put(route("expense.update",o.id),{onSuccess:()=>$()}):o.post(route("expense.store"),{onSuccess:()=>$()})},se=a=>{confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")&&J.delete(route("expense.destroy",a),{onSuccess:()=>{const e=c.expenses.findIndex(t=>t.id===a);e!==-1&&c.expenses.splice(e,1)},onError:()=>{alert("Gagal menghapus pengeluaran. Silakan coba lagi.")}})};return le(()=>{g.value.saving_expense&&console.log(P.value)}),(a,e)=>(n(),N(de,{title:"Expenses"},{default:p(()=>[s("div",pe,[a.$page.props.flash.success?(n(),l("div",me,i(a.$page.props.flash.success),1)):m("",!0),a.$page.props.flash.error?(n(),l("div",ce,i(a.$page.props.flash.error),1)):m("",!0),s("div",ge,[d(E,{onClick:e[0]||(e[0]=t=>Y("create"))},{default:p(()=>e[14]||(e[14]=[u("Tambah Pengeluaran")])),_:1}),s("div",fe,[s("div",_e,[e[15]||(e[15]=s("span",{class:"text-sm font-medium text-gray-700"},"Filter:",-1)),s("div",ve,[_(s("select",{id:"year","onUpdate:modelValue":e[1]||(e[1]=t=>A.value=t),class:"block w-full border rounded-md p-2"},[(n(!0),l(v,null,b(H.value,t=>(n(),l("option",{key:t,value:t},i(t),9,be))),128))],512),[[T,A.value]])]),s("div",ye,[_(s("select",{id:"month","onUpdate:modelValue":e[2]||(e[2]=t=>S.value=t),class:"block w-full border rounded-md p-2"},[(n(),l(v,null,b(W,(t,x)=>s("option",{key:x,value:x+1},i(t),9,xe)),64))],512),[[T,S.value]])])]),s("div",ke,[d(L,{modelValue:y.value,"onUpdate:modelValue":e[3]||(e[3]=t=>y.value=t),placeholder:"Cari...",class:"pl-10 pr-4 py-2 border rounded-md w-full"},null,8,["modelValue"]),e[16]||(e[16]=s("svg",{class:"absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z"})],-1))])])]),s("div",we,[s("table",Ce,[s("thead",he,[s("tr",null,[e[17]||(e[17]=s("th",{class:"px-4 py-2 text-left"},"No",-1)),e[18]||(e[18]=s("th",{class:"px-4 py-2 text-left"},"Tanggal",-1)),e[19]||(e[19]=s("th",{class:"px-4 py-2 text-left"},"Nominal",-1)),e[20]||(e[20]=s("th",{class:"px-4 py-2 text-left"},"Kategori",-1)),e[21]||(e[21]=s("th",{class:"px-4 py-2 text-left"},"Keterangan",-1)),e[22]||(e[22]=s("th",{class:"px-4 py-2 text-left"},"Pembayaran",-1)),e[23]||(e[23]=s("th",{class:"px-4 py-2 text-left"},"Rekening",-1)),g.value.btn_edit||g.value.btn_delete?(n(),l("th",Ae,"Aksi")):m("",!0)])]),s("tbody",null,[(n(!0),l(v,null,b(G.value,(t,x)=>{var D,V;return n(),l("tr",{key:t.id,class:"border-b hover:bg-gray-100"},[s("td",Se,i(x+1),1),s("td",Ve,i(t.date),1),s("td",Te,i(U(t.amount)),1),s("td",$e,i(t.category.name),1),s("td",De,i(((D=t.sub_category)==null?void 0:D.name)||"-"),1),s("td",Me,i(t.payment),1),s("td",Be,i(((V=t.account_bank)==null?void 0:V.name)||"-"),1),g.value.btn_edit||g.value.btn_delete?(n(),l("td",Ue,[g.value.btn_edit?(n(),N(q,{key:0,onClick:ae=>Y("edit",t)},{default:p(()=>e[24]||(e[24]=[u("Edit")])),_:2},1032,["onClick"])):m("",!0),g.value.btn_delete?(n(),N(E,{key:1,class:"ml-2 bg-red-600 hover:bg-red-700",onClick:ae=>se(t.id)},{default:p(()=>e[25]||(e[25]=[u("Hapus")])),_:2},1032,["onClick"])):m("",!0)])):m("",!0)])}),128))])])]),d(ie,{show:B.value,title:h.value?"Edit Pengeluaran":"Tambah Pengeluaran",onClose:$},{content:p(()=>[s("form",{onSubmit:re(te,["prevent"])},[s("div",Fe,[d(w,{for:"date"},{default:p(()=>e[26]||(e[26]=[u(" Tanggal "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),d(L,{id:"date",type:"date",modelValue:r(o).date,"onUpdate:modelValue":e[4]||(e[4]=t=>r(o).date=t),class:"block w-full"},null,8,["modelValue"]),d(C,{message:r(o).errors.date},null,8,["message"])]),s("div",Ie,[d(w,{for:"category_id"},{default:p(()=>e[27]||(e[27]=[u(" Kategori "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"category_id","onUpdate:modelValue":e[5]||(e[5]=t=>r(o).category_id=t),class:"block w-full border rounded-md p-2",onChange:e[6]||(e[6]=(...t)=>a.onCategoryChange&&a.onCategoryChange(...t))},[e[28]||(e[28]=s("option",{disabled:"",value:""},"Pilih Kategori",-1)),(n(!0),l(v,null,b(M.categories,t=>(n(),l("option",{key:t.id,value:t.id,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Ee,"(Tidak Aktif)"))],8,Ne))),128))],544),[[T,r(o).category_id]]),d(C,{message:r(o).errors.category_id},null,8,["message"])]),s("div",Le,[d(w,{for:"sub_kategori_id"},{default:p(()=>e[29]||(e[29]=[u(" Keterangan "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"sub_kategori_id","onUpdate:modelValue":e[7]||(e[7]=t=>r(o).sub_kategori_id=t),class:"block w-full border rounded-md p-2",disabled:!r(o).category_id,onChange:R},[e[30]||(e[30]=s("option",{disabled:"",value:""},"Pilih Keterangan",-1)),(n(!0),l(v,null,b(Q.value,t=>(n(),l("option",{key:t.id,value:t.id,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Re,"(Tidak Aktif)"))],8,Ke))),128))],40,Pe),[[T,r(o).sub_kategori_id]]),d(C,{message:r(o).errors.sub_kategori_id},null,8,["message"])]),s("div",Ye,[d(w,{for:"amount"},{default:p(()=>e[31]||(e[31]=[u(" Nominal "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),d(L,{id:"amount",type:"text",modelValue:F.value,"onUpdate:modelValue":e[8]||(e[8]=t=>F.value=t),onInput:a.handleAmountInput,class:"block w-full"},null,8,["modelValue","onInput"]),d(C,{message:r(o).errors.amount},null,8,["message"])]),s("div",je,[d(w,{for:"payment"},{default:p(()=>e[32]||(e[32]=[u(" Pembayaran "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),s("div",Oe,[s("label",Je,[_(s("input",{type:"radio","onUpdate:modelValue":e[9]||(e[9]=t=>r(o).payment=t),value:"Transfer",class:"mr-2",onChange:e[10]||(e[10]=t=>r(o).account_id="")},null,544),[[O,r(o).payment]]),e[33]||(e[33]=s("span",null,"Transfer",-1))]),K.value?m("",!0):(n(),l("label",qe,[_(s("input",{type:"radio","onUpdate:modelValue":e[11]||(e[11]=t=>r(o).payment=t),value:"Tunai",class:"mr-2",onChange:e[12]||(e[12]=t=>r(o).account_id=null)},null,544),[[O,r(o).payment]]),e[34]||(e[34]=s("span",null,"Tunai",-1))]))]),d(C,{message:r(o).errors.payment},null,8,["message"])]),r(o).payment==="Transfer"?(n(),l("div",He,[d(w,{for:"account_id"},{default:p(()=>e[35]||(e[35]=[u(" Sumber Rekening "),s("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),_(s("select",{id:"account_id","onUpdate:modelValue":e[13]||(e[13]=t=>r(o).account_id=t),class:"block w-full border rounded-md p-2",required:""},[e[36]||(e[36]=s("option",{disabled:"",value:""},"Pilih Rekening",-1)),s("optgroup",We,[(n(!0),l(v,null,b(M.accountBanks,t=>(n(),l("option",{key:t.id,value:`account_${t.id}`,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Ge,"(Tidak Aktif)"))],8,ze))),128))]),!K.value&&g.value.saving_expense?(n(),l("optgroup",Qe,[(n(!0),l(v,null,b(P.value,t=>(n(),l("option",{key:t.id,value:`subcategory_${t.id}`,disabled:!t.is_active},[u(i(t.name)+" ",1),t.is_active?m("",!0):(n(),l("span",Ze,"(Tidak Aktif)"))],8,Xe))),128))])):m("",!0)],512),[[T,r(o).account_id]]),d(C,{message:r(o).errors.account_id},null,8,["message"])])):m("",!0),s("div",et,[d(q,{type:"button",onClick:$},{default:p(()=>e[37]||(e[37]=[u("Batal")])),_:1}),d(E,{class:"ml-3",type:"submit"},{default:p(()=>[u(i(h.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}},pt=ue(tt,[["__scopeId","data-v-ca70e976"]]);export{pt as default};
