import{d as h,k as V,c as D,o as l,w as x,a as t,b as B,g as p,e as r,F as m,h as f,n as y,p as b,x as w,f as C,t as S,W as M}from"./app-BAijexpd.js";import{A as $}from"./AppLayout-DlFxLZi-.js";import{_ as q}from"./PrimaryButton-DOrKTp0i.js";import{_ as F}from"./_plugin-vue_export-helper-DlAUqK2U.js";const L={class:"p-4"},O={class:"container mx-auto p-2"},T={class:"flex justify-between items-center mb-6"},U={class:"bg-white rounded-lg shadow-md overflow-hidden"},W={class:"min-w-full"},j={class:"divide-y divide-gray-200"},z={class:"px-6 py-4 whitespace-nowrap"},E=["value","disabled","onChange"],I={class:"px-6 py-4 whitespace-nowrap"},P={class:"category-name"},G={key:0,class:"already-exists"},H={class:"px-6 py-4 whitespace-nowrap subcategory-indent"},J=["value","disabled","onChange"],Q={class:"px-6 py-4 whitespace-nowrap subcategory-indent"},R={class:"subcategory-name"},X={key:0,class:"already-exists"},Y={key:1},Z={__name:"ManageCategories",props:{categories:Array,subCategories:Array,userCategories:Array,userSubCategories:Array},setup(k){const d=k,i=h([]),n=h([]),_=V(()=>{const s=new Set;return d.categories.filter(e=>s.has(e.name)?!1:(s.add(e.name),!0))}),g=s=>d.subCategories.filter(e=>e.category_id===s),c=s=>d.userCategories.some(e=>e.name===s.name),u=s=>d.userSubCategories.some(e=>e.name===s.name),A=s=>{n.value.includes(s.id)?i.value.includes(s.category_id)||i.value.push(s.category_id):d.subCategories.some(a=>a.category_id===s.category_id&&n.value.includes(a.id))||(i.value=i.value.filter(a=>a!==s.category_id))},K=s=>{i.value.includes(s.id)||(n.value=n.value.filter(e=>!g(s.id).some(a=>a.id===e)))},N=()=>{M.post(route("categories.save"),{categories:i.value,subCategories:n.value},{onSuccess:()=>{i.value=[],n.value=[]}})};return(s,e)=>(l(),D($,{title:"Kelola Kategori"},{default:x(()=>[t("div",L,[t("div",O,[t("div",T,[e[3]||(e[3]=t("h1",{class:"text-2xl font-semibold text-gray-800"},"Kelola Kategori",-1)),B(q,{onClick:N},{default:x(()=>e[2]||(e[2]=[p("Simpan Kategori Dipilih")])),_:1})]),t("div",U,[t("table",W,[e[5]||(e[5]=t("thead",{class:"bg-gray-50"},[t("tr",null,[t("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"},"Pilih"),t("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"},"Nama Kategori")])],-1)),t("tbody",j,[_.value.length>0?(l(!0),r(m,{key:0},f(_.value,a=>(l(),r(m,{key:a.id},[t("tr",{class:y({"disabled-row":c(a)})},[t("td",z,[b(t("input",{type:"checkbox","onUpdate:modelValue":e[0]||(e[0]=o=>i.value=o),value:a.id,disabled:c(a),onChange:o=>K(a)},null,40,E),[[w,i.value]])]),t("td",I,[t("div",P,[p(S(a.name)+" ",1),c(a)?(l(),r("span",G,"(Sudah Ada)")):C("",!0)])])],2),(l(!0),r(m,null,f(g(a.id),o=>(l(),r("tr",{key:o.id,class:y({"disabled-row":u(o)})},[t("td",H,[b(t("input",{type:"checkbox","onUpdate:modelValue":e[1]||(e[1]=v=>n.value=v),value:o.id,disabled:u(o),onChange:v=>A(o)},null,40,J),[[w,n.value]])]),t("td",Q,[t("div",R,[p(S(o.name)+" ",1),u(o)?(l(),r("span",X,"(Sudah Ada)")):C("",!0)])])],2))),128))],64))),128)):(l(),r("tr",Y,e[4]||(e[4]=[t("td",{colspan:"2",class:"px-6 py-4 text-center text-sm text-gray-500"},"Tidak ada data kategori.",-1)])))])])])])])]),_:1}))}},oe=F(Z,[["__scopeId","data-v-aad6e806"]]);export{oe as default};
