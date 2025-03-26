import{d as v,i as E,C as q,k as b,c as O,o as d,w as m,a as e,e as p,f as C,b as n,t as l,F as D,h as z,n as H,p as S,x as Q,g as u,v as R,q as G,u as i,y as J}from"./app-CxSnI49r.js";import{A as W}from"./AppLayout-DC6qsIqF.js";import{_ as X}from"./CustomModal-DYkmDggW.js";import{_ as $}from"./PrimaryButton-D7UxiV5k.js";import{_ as Y}from"./SecondaryButton-CG2pnUvN.js";import{_ as y}from"./InputLabel-DoM7Stot.js";import{_ as K}from"./TextInput-CeMwzNia.js";import{_ as M}from"./InputError-DsGhxeJI.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const Z={class:"p-4 space-y-4"},ee={key:0,class:"bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg"},te={class:"flex items-center"},se={key:1,class:"bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg"},ae={class:"flex items-center"},oe={class:"bg-white rounded-xl shadow-md overflow-hidden"},le={class:"p-6"},re={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"},ne={class:"text-sm font-medium text-gray-600"},ie={class:"bg-white rounded-xl shadow-md p-5"},de={class:"flex flex-col md:flex-row md:items-end gap-4"},ue={class:"flex-1"},me={class:"relative"},pe={class:"bg-white rounded-xl shadow-md overflow-hidden"},ce={class:"overflow-x-auto"},ge={class:"min-w-full divide-y divide-gray-200"},ve={class:"bg-white divide-y divide-gray-200"},xe={class:"px-6 py-4 whitespace-nowrap text-sm text-gray-500"},fe={class:"px-6 py-4 whitespace-nowrap text-sm text-gray-500"},be={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"},ye={class:"px-6 py-4 text-sm text-gray-500 max-w-xs truncate"},we={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600"},_e={class:"px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600"},he={class:"px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"},ke={key:0},Ce={class:"bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-xl"},Se={class:"flex-1 flex justify-between sm:hidden"},Me=["disabled"],Le=["disabled"],Te={class:"hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"},Ve={class:"text-sm text-gray-700"},Be={class:"font-medium"},De={class:"font-medium"},ze={class:"font-medium"},$e={class:"flex items-center space-x-2"},Ke={class:"relative z-0 inline-flex rounded-md shadow-sm -space-x-px","aria-label":"Pagination"},je=["disabled"],Ie=["disabled"],Ne={class:"mb-4"},Ae={class:"mb-4"},Fe={class:"mb-4"},Pe={class:"mb-4"},Ue={class:"flex items-center"},Ee={class:"flex justify-end mt-4"},qe={key:0},Oe={key:1},et={__name:"Index",props:{savings:Array,categories:Array,subCategories:Array},setup(j){const w=j;v(E().props.settings);const g=v(""),_=v(!1),r=v(1),c=v(10),o=q({name:"",description:"",is_active:!0,category_id:""}),I=()=>{const a=w.categories.find(t=>t.name==="Saving (Tabungan)");return a?a.id:null},N=()=>{o.category_id=I(),_.value=!0},h=()=>{o.reset(),_.value=!1},A=()=>{o.post(route("sub-category.store"),{onSuccess:()=>{h()}})},x=b(()=>w.savings.filter(a=>{var t;return a.category.name.toLowerCase().includes(g.value.toLowerCase())||((t=a.sub_category)==null?void 0:t.name.toLowerCase().includes(g.value.toLowerCase()))||a.note.toLowerCase().includes(g.value.toLowerCase())})),L=b(()=>{const a=(r.value-1)*c.value,t=a+c.value;return x.value.slice(a,t)}),k=b(()=>Math.ceil(x.value.length/c.value)),T=()=>{r.value<k.value&&r.value++},V=()=>{r.value>1&&r.value--},F=b(()=>{const a={};return w.savings.forEach(t=>{var s;(!a[t.sub_category_id]||new Date(t.date)>new Date(a[t.sub_category_id].date))&&(a[t.sub_category_id]={id:t.sub_category_id,name:((s=t.sub_category)==null?void 0:s.name)||"Tanpa Sub Kategori",balance:t.balance,date:t.date})}),Object.values(a)}),f=a=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a||0),P=a=>{if(!a)return"-";try{return new Date(a).toLocaleDateString("id-ID",{day:"2-digit",month:"short",year:"numeric"})}catch(t){return console.error("Error formatting date:",t),a}};return(a,t)=>(d(),O(W,{title:"Saving (Tabungan)"},{default:m(()=>[e("div",Z,[a.$page.props.flash.success?(d(),p("div",ee,[e("div",te,[t[6]||(t[6]=e("svg",{class:"h-5 w-5 mr-2",fill:"currentColor",viewBox:"0 0 20 20"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})],-1)),e("p",null,l(a.$page.props.flash.success),1)])])):C("",!0),a.$page.props.flash.error?(d(),p("div",se,[e("div",ae,[t[7]||(t[7]=e("svg",{class:"h-5 w-5 mr-2",fill:"currentColor",viewBox:"0 0 20 20"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z","clip-rule":"evenodd"})],-1)),e("p",null,l(a.$page.props.flash.error),1)])])):C("",!0),e("div",oe,[e("div",le,[t[8]||(t[8]=e("h3",{class:"text-lg font-semibold text-gray-800 mb-4"},"Saldo Tabungan per Kategori",-1)),e("div",re,[(d(!0),p(D,null,z(F.value,s=>(d(),p("div",{key:s.id,class:"bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200"},[e("h4",ne,l(s.name),1),e("p",{class:H(["text-2xl font-bold mt-2",s.balance<0?"text-red-600":"text-green-600"])},l(f(s.balance)),3)]))),128))])])]),e("div",ie,[e("div",de,[e("div",ue,[t[10]||(t[10]=e("label",{class:"block text-sm font-medium text-gray-700 mb-1"},"Cari Transaksi",-1)),e("div",me,[S(e("input",{"onUpdate:modelValue":t[0]||(t[0]=s=>g.value=s),type:"text",class:"w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-10",placeholder:"Cari berdasarkan kategori atau catatan..."},null,512),[[Q,g.value]]),t[9]||(t[9]=e("span",{class:"absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5 text-gray-400",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"})])],-1))])]),n($,{onClick:N,class:"w-full md:w-auto"},{default:m(()=>t[11]||(t[11]=[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-5 w-5 mr-2",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z","clip-rule":"evenodd"})],-1),u(" Tambah Kategori ")])),_:1})])]),e("div",pe,[e("div",ce,[e("table",ge,[t[13]||(t[13]=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl"},"No"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Tanggal"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Kategori"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Catatan"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Masuk"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Keluar"),e("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl"},"Saldo")])],-1)),e("tbody",ve,[(d(!0),p(D,null,z(L.value,(s,U)=>{var B;return d(),p("tr",{key:s.id,class:"hover:bg-gray-50/50 transition-colors"},[e("td",xe,l((r.value-1)*c.value+U+1),1),e("td",fe,l(P(s.date)),1),e("td",be,l(((B=s.sub_category)==null?void 0:B.name)||"-"),1),e("td",ye,l(s.note||"-"),1),e("td",we,l(s.amount>0?f(s.amount):"-"),1),e("td",_e,l(s.amount<0?f(Math.abs(s.amount)):"-"),1),e("td",he,l(f(s.balance)),1)])}),128)),L.value.length===0?(d(),p("tr",ke,t[12]||(t[12]=[e("td",{colspan:"7",class:"px-6 py-4 text-center text-sm text-gray-500"}," Tidak ada data transaksi ditemukan ",-1)]))):C("",!0)])])]),e("div",Ce,[e("div",Se,[e("button",{onClick:V,disabled:r.value===1,class:"relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Sebelumnya ",8,Me),e("button",{onClick:T,disabled:r.value===k.value,class:"ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"}," Selanjutnya ",8,Le)]),e("div",Te,[e("div",null,[e("p",Ve,[t[14]||(t[14]=u(" Menampilkan ")),e("span",Be,l((r.value-1)*c.value+1),1),t[15]||(t[15]=u(" sampai ")),e("span",De,l(Math.min(r.value*c.value,x.value.length)),1),t[16]||(t[16]=u(" dari ")),e("span",ze,l(x.value.length),1),t[17]||(t[17]=u(" hasil "))])]),e("div",$e,[S(e("select",{"onUpdate:modelValue":t[1]||(t[1]=s=>c.value=s),onChange:t[2]||(t[2]=s=>r.value=1),class:"border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"},t[18]||(t[18]=[e("option",{value:"10"},"10 per halaman",-1),e("option",{value:"25"},"25 per halaman",-1),e("option",{value:"50"},"50 per halaman",-1)]),544),[[R,c.value]]),e("nav",Ke,[e("button",{onClick:V,disabled:r.value===1,class:"relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"},t[19]||(t[19]=[e("span",{class:"sr-only"},"Sebelumnya",-1),e("svg",{class:"h-5 w-5",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z","clip-rule":"evenodd"})],-1)]),8,je),e("button",{onClick:T,disabled:r.value===k.value,class:"relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"},t[20]||(t[20]=[e("span",{class:"sr-only"},"Selanjutnya",-1),e("svg",{class:"h-5 w-5",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z","clip-rule":"evenodd"})],-1)]),8,Ie)])])])])]),n(X,{show:_.value,title:"Tambah Kategori Tabungan",onClose:h},{content:m(()=>[e("form",{onSubmit:G(A,["prevent"])},[e("div",Ne,[n(y,{for:"name"},{default:m(()=>t[21]||(t[21]=[u(" Nama Kategori Tabungan "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),n(K,{id:"name",modelValue:i(o).name,"onUpdate:modelValue":t[3]||(t[3]=s=>i(o).name=s),class:"block w-full",required:""},null,8,["modelValue"]),n(M,{message:i(o).errors.name},null,8,["message"])]),e("div",Ae,[n(y,{for:"description"},{default:m(()=>t[22]||(t[22]=[u(" Deskripsi ")])),_:1}),n(K,{id:"description",modelValue:i(o).description,"onUpdate:modelValue":t[4]||(t[4]=s=>i(o).description=s),class:"block w-full"},null,8,["modelValue"]),n(M,{message:i(o).errors.description},null,8,["message"])]),e("div",Fe,[n(y,null,{default:m(()=>t[23]||(t[23]=[u(" Kategori Induk ")])),_:1}),t[24]||(t[24]=e("div",{class:"p-2 bg-gray-100 rounded"}," Saving (Tabungan) ",-1)),t[25]||(t[25]=e("small",{class:"text-gray-500"},'Kategori tabungan akan otomatis terhubung dengan "Saving (Tabungan)"',-1))]),e("div",Pe,[n(y,{for:"is_active"},{default:m(()=>t[26]||(t[26]=[u(" Status ")])),_:1}),e("div",Ue,[S(e("input",{type:"checkbox",id:"is_active","onUpdate:modelValue":t[5]||(t[5]=s=>i(o).is_active=s),class:"mr-2"},null,512),[[J,i(o).is_active]]),t[27]||(t[27]=e("label",{for:"is_active"},"Aktif",-1))]),n(M,{message:i(o).errors.is_active},null,8,["message"])]),e("div",Ee,[n(Y,{type:"button",onClick:h},{default:m(()=>t[28]||(t[28]=[u("Batal")])),_:1}),n($,{class:"ml-3",type:"submit",disabled:i(o).processing},{default:m(()=>[i(o).processing?(d(),p("span",qe,"Menyimpan...")):(d(),p("span",Oe,"Simpan"))]),_:1},8,["disabled"])])],32)]),_:1},8,["show"])])]),_:1}))}};export{et as default};
