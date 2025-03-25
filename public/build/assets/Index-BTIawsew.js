import{d as g,i as q,C as E,k as b,c as O,o as u,w as x,a as e,e as c,f as C,b as n,t as o,F as D,h as T,n as W,p as y,x as V,g as m,v as H,q as Q,u as d,y as R,W as G}from"./app-vmWeJ-Uh.js";import{A as J}from"./AppLayout-MCLPXt_C.js";import{_ as X}from"./CustomModal-GWwiuiFj.js";import{_ as z}from"./PrimaryButton-D1qYauQo.js";import{_ as Y}from"./SecondaryButton-BPnMJfKF.js";import{_ as $}from"./InputLabel-BgIlgCk3.js";import{_ as Z}from"./TextInput-DmWGxOiV.js";import{_ as j}from"./InputError-Cv51u04h.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const ee={class:"p-4 space-y-4"},te={key:0,class:"bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg"},se={class:"flex items-center"},ae={key:1,class:"bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg"},oe={class:"flex items-center"},re={class:"bg-white rounded-xl shadow-md overflow-hidden"},le={class:"p-6"},ne={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"},de={class:"text-sm font-medium text-gray-600"},ie={class:"bg-white rounded-xl shadow-md p-5"},ue={class:"flex flex-col md:flex-row md:items-end gap-4"},ce={class:"flex-1"},me={class:"relative"},pe={class:"bg-white rounded-xl shadow-md overflow-hidden"},ge={class:"overflow-x-auto"},xe={class:"min-w-full divide-y divide-gray-200"},ve={class:"bg-white divide-y divide-gray-200"},fe={class:"px-6 py-4 whitespace-nowrap text-sm text-gray-500"},be={class:"px-6 py-4 whitespace-nowrap text-sm text-gray-500"},ye={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"},we={class:"px-6 py-4 text-sm text-gray-500 max-w-xs truncate"},he={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600"},_e={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600"},ke={class:"px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"},Ce={key:0},Me={class:"bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-xl"},Se={class:"flex-1 flex justify-between sm:hidden"},Le=["disabled"],Be=["disabled"],De={class:"hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"},Te={class:"text-sm text-gray-700"},Ve={class:"font-medium"},ze={class:"font-medium"},$e={class:"font-medium"},je={class:"flex items-center space-x-2"},Ke={class:"relative z-0 inline-flex rounded-md shadow-sm -space-x-px","aria-label":"Pagination"},Ne=["disabled"],Ae=["disabled"],Fe={class:"flex items-center"},Ie={class:"flex justify-end space-x-3 pt-4"},Ge={__name:"Index",props:{savings:Array,categories:Array,subCategories:Array},setup(K){const w=K;g(q().props.settings);const p=g(""),h=g(!1),r=g(1),i=g(10),l=E({name:"",description:"",is_active:!0,category_id:""}),N=()=>{const a=w.categories.find(t=>t.name==="Saving (Tabungan)");return a?a.id:null},A=()=>{l.category_id=N(),h.value=!0},_=()=>{l.reset(),h.value=!1},F=()=>{l.post(route("sub-category.store"),{onSuccess:()=>{_(),G.reload()}})},v=b(()=>w.savings.filter(a=>{var t;return a.category.name.toLowerCase().includes(p.value.toLowerCase())||((t=a.sub_category)==null?void 0:t.name.toLowerCase().includes(p.value.toLowerCase()))||a.note.toLowerCase().includes(p.value.toLowerCase())})),M=b(()=>{const a=(r.value-1)*i.value,t=a+i.value;return v.value.slice(a,t)}),k=b(()=>Math.ceil(v.value.length/i.value)),S=()=>{r.value<k.value&&r.value++},L=()=>{r.value>1&&r.value--},I=b(()=>{const a={};return w.savings.forEach(t=>{var s;(!a[t.sub_category_id]||new Date(t.date)>new Date(a[t.sub_category_id].date))&&(a[t.sub_category_id]={id:t.sub_category_id,name:((s=t.sub_category)==null?void 0:s.name)||"Tanpa Sub Kategori",balance:t.balance,date:t.date})}),Object.values(a)}),f=a=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a||0),P=a=>{if(!a)return"-";try{return new Date(a).toLocaleDateString("id-ID",{day:"2-digit",month:"short",year:"numeric"})}catch(t){return console.error("Error formatting date:",t),a}};return(a,t)=>(u(),O(J,{title:"Saving (Tabungan)"},{default:x(()=>[e("div",ee,[a.$page.props.flash.success?(u(),c("div",te,[e("div",se,[t[6]||(t[6]=e("svg",{class:"h-5 w-5 mr-2",fill:"currentColor",viewBox:"0 0 20 20"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})],-1)),e("p",null,o(a.$page.props.flash.success),1)])])):C("",!0),a.$page.props.flash.error?(u(),c("div",ae,[e("div",oe,[t[7]||(t[7]=e("svg",{class:"h-5 w-5 mr-2",fill:"currentColor",viewBox:"0 0 20 20"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z","clip-rule":"evenodd"})],-1)),e("p",null,o(a.$page.props.flash.error),1)])])):C("",!0),e("div",re,[e("div",le,[t[8]||(t[8]=e("h3",{class:"text-lg font-semibold text-gray-800 mb-4"},"Saldo Tabungan per Kategori",-1)),e("div",ne,[(u(!0),c(D,null,T(I.value,s=>(u(),c("div",{key:s.id,class:"bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200"},[e("h4",de,o(s.name),1),e("p",{class:W(["text-2xl font-bold mt-2",s.balance<0?"text-red-600":"text-green-600"])},o(f(s.balance)),3)]))),128))])])]),e("div",ie,[e("div",ue,[e("div",ce,[t[10]||(t[10]=e("label",{class:"block text-sm font-medium text-gray-700 mb-1"},"Cari Transaksi",-1)),e("div",me,[y(e("input",{"onUpdate:modelValue":t[0]||(t[0]=s=>p.value=s),type:"text",class:"w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-10",placeholder:"Cari berdasarkan kategori atau catatan..."},null,512),[[V,p.value]]),t[9]||(t[9]=e("span",{class:"absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5 text-gray-400",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"})])],-1))])]),n(z,{onClick:A,class:"w-full md:w-auto"},{default:x(()=>t[11]||(t[11]=[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-5 w-5 mr-2",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z","clip-rule":"evenodd"})],-1),m(" Tambah Kategori ")])),_:1})])]),e("div",pe,[e("div",ge,[e("table",xe,[t[13]||(t[13]=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl"},"No"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Tanggal"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Kategori"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Catatan"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Masuk"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Keluar"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl"},"Saldo")])],-1)),e("tbody",ve,[(u(!0),c(D,null,T(M.value,(s,U)=>{var B;return u(),c("tr",{key:s.id,class:"hover:bg-gray-50/50 transition-colors"},[e("td",fe,o((r.value-1)*i.value+U+1),1),e("td",be,o(P(s.date)),1),e("td",ye,o(((B=s.sub_category)==null?void 0:B.name)||"-"),1),e("td",we,o(s.note||"-"),1),e("td",he,o(s.amount>0?f(s.amount):"-"),1),e("td",_e,o(s.amount<0?f(Math.abs(s.amount)):"-"),1),e("td",ke,o(f(s.balance)),1)])}),128)),M.value.length===0?(u(),c("tr",Ce,t[12]||(t[12]=[e("td",{colspan:"7",class:"px-6 py-4 text-center text-sm text-gray-500"}," Tidak ada data transaksi ditemukan ",-1)]))):C("",!0)])])]),e("div",Me,[e("div",Se,[e("button",{onClick:L,disabled:r.value===1,class:"relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Sebelumnya ",8,Le),e("button",{onClick:S,disabled:r.value===k.value,class:"ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Selanjutnya ",8,Be)]),e("div",De,[e("div",null,[e("p",Te,[t[14]||(t[14]=m(" Menampilkan ")),e("span",Ve,o((r.value-1)*i.value+1),1),t[15]||(t[15]=m(" sampai ")),e("span",ze,o(Math.min(r.value*i.value,v.value.length)),1),t[16]||(t[16]=m(" dari ")),e("span",$e,o(v.value.length),1),t[17]||(t[17]=m(" hasil "))])]),e("div",je,[y(e("select",{"onUpdate:modelValue":t[1]||(t[1]=s=>i.value=s),onChange:t[2]||(t[2]=s=>r.value=1),class:"border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"},t[18]||(t[18]=[e("option",{value:"10"},"10 per halaman",-1),e("option",{value:"25"},"25 per halaman",-1),e("option",{value:"50"},"50 per halaman",-1)]),544),[[H,i.value]]),e("nav",Ke,[e("button",{onClick:L,disabled:r.value===1,class:"relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"},t[19]||(t[19]=[e("span",{class:"sr-only"},"Sebelumnya",-1),e("svg",{class:"h-5 w-5",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z","clip-rule":"evenodd"})],-1)]),8,Ne),e("button",{onClick:S,disabled:r.value===k.value,class:"relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"},t[20]||(t[20]=[e("span",{class:"sr-only"},"Selanjutnya",-1),e("svg",{class:"h-5 w-5",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z","clip-rule":"evenodd"})],-1)]),8,Ae)])])])])]),n(X,{show:h.value,title:"Tambah Kategori Tabungan",onClose:_},{content:x(()=>[e("form",{onSubmit:Q(F,["prevent"]),class:"space-y-4"},[e("div",null,[n($,{for:"name",value:"Nama Kategori",required:""}),n(Z,{id:"name",modelValue:d(l).name,"onUpdate:modelValue":t[3]||(t[3]=s=>d(l).name=s),class:"mt-1 block w-full",required:""},null,8,["modelValue"]),n(j,{message:d(l).errors.name,class:"mt-1"},null,8,["message"])]),e("div",null,[n($,{for:"description",value:"Deskripsi (Opsional)"}),y(e("textarea",{id:"description","onUpdate:modelValue":t[4]||(t[4]=s=>d(l).description=s),rows:"3",class:"mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"},null,512),[[V,d(l).description]]),n(j,{message:d(l).errors.description,class:"mt-1"},null,8,["message"])]),e("div",Fe,[y(e("input",{id:"is_active","onUpdate:modelValue":t[5]||(t[5]=s=>d(l).is_active=s),type:"checkbox",class:"h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"},null,512),[[R,d(l).is_active]]),t[21]||(t[21]=e("label",{for:"is_active",class:"ml-2 block text-sm text-gray-700"}," Aktif ",-1))]),e("div",Ie,[n(Y,{type:"button",onClick:_},{default:x(()=>t[22]||(t[22]=[m(" Batal ")])),_:1}),n(z,{type:"submit",disabled:d(l).processing},{default:x(()=>t[23]||(t[23]=[m(" Simpan ")])),_:1},8,["disabled"])])],32)]),_:1},8,["show"])])]),_:1}))}};export{Ge as default};
