import{C as S,k as J,e as j,o as v,a as r,f as U,b as t,u as s,p as i,A as w,y as C,w as B,g as N,q as $}from"./app-9QPMRC04.js";import{_ as m}from"./InputLabel-BB1nO45r.js";import{_ as d}from"./TextInput-DHSiMCnf.js";import{_ as n}from"./InputError-Wk88TV3H.js";import{_ as h}from"./PrimaryButton-aP2qe7s9.js";const q={class:"mt-4 sm:mt-0 p-4 sm:p-6 bg-white shadow rounded-lg max-w-3xl mx-auto"},D={class:"flex items-center"},E={key:0,class:"space-y-4"},M={class:"flex justify-end"},O={__name:"UpdateJobForm",props:{job:Object,userId:Number},setup(V){var p,b,c,f,g,y,x,_;const a=V,e=S({company_name:((p=a.job)==null?void 0:p.company_name)||"",job_title:((b=a.job)==null?void 0:b.job_title)||"",job_description:((c=a.job)==null?void 0:c.job_description)||"",salary:((f=a.job)==null?void 0:f.salary)||"",bpjs:((g=a.job)==null?void 0:g.bpjs)||!1,bpjs_company_percentage:((y=a.job)==null?void 0:y.bpjs_company_percentage)||"",bpjs_employee_percentage:((x=a.job)==null?void 0:x.bpjs_employee_percentage)||"",benefits:((_=a.job)==null?void 0:_.benefits)||""}),u=J(()=>!!a.job),k=()=>{u.value?e.put(route("job.update",a.job.id),{preserveScroll:!0,onSuccess:()=>alert("Job updated successfully!")}):e.post(route("job.store"),{preserveScroll:!0,onSuccess:()=>alert("Job added successfully!")})};return(P,o)=>(v(),j("div",q,[r("form",{onSubmit:$(k,["prevent"]),class:"mt-4 space-y-6"},[r("div",null,[t(m,{for:"company_name",value:"Company Name",class:"block text-sm font-medium text-gray-700"}),t(d,{id:"company_name",modelValue:s(e).company_name,"onUpdate:modelValue":o[0]||(o[0]=l=>s(e).company_name=l),required:"",autofocus:"",class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,8,["modelValue"]),t(n,{message:s(e).errors.company_name,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",null,[t(m,{for:"job_title",value:"Job Title",class:"block text-sm font-medium text-gray-700"}),t(d,{id:"job_title",modelValue:s(e).job_title,"onUpdate:modelValue":o[1]||(o[1]=l=>s(e).job_title=l),required:"",class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,8,["modelValue"]),t(n,{message:s(e).errors.job_title,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",null,[t(m,{for:"job_description",value:"Job Description",class:"block text-sm font-medium text-gray-700"}),i(r("textarea",{id:"job_description","onUpdate:modelValue":o[2]||(o[2]=l=>s(e).job_description=l),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,512),[[w,s(e).job_description]]),t(n,{message:s(e).errors.job_description,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",null,[t(m,{for:"salary",value:"Salary",class:"block text-sm font-medium text-gray-700"}),t(d,{id:"salary",modelValue:s(e).salary,"onUpdate:modelValue":o[3]||(o[3]=l=>s(e).salary=l),type:"number",class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,8,["modelValue"]),t(n,{message:s(e).errors.salary,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",D,[i(r("input",{id:"bpjs",type:"checkbox","onUpdate:modelValue":o[4]||(o[4]=l=>s(e).bpjs=l),class:"h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"},null,512),[[C,s(e).bpjs]]),o[8]||(o[8]=r("label",{for:"bpjs",class:"ml-2 text-sm text-gray-700"},"Has BPJS?",-1))]),s(e).bpjs?(v(),j("div",E,[r("div",null,[t(m,{for:"bpjs_company_percentage",value:"BPJS - Company Contribution (%)",class:"block text-sm font-medium text-gray-700"}),t(d,{id:"bpjs_company_percentage",modelValue:s(e).bpjs_company_percentage,"onUpdate:modelValue":o[5]||(o[5]=l=>s(e).bpjs_company_percentage=l),type:"number",step:"0.01",class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,8,["modelValue"]),t(n,{message:s(e).errors.bpjs_company_percentage,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",null,[t(m,{for:"bpjs_employee_percentage",value:"BPJS - Employee Contribution (%)",class:"block text-sm font-medium text-gray-700"}),t(d,{id:"bpjs_employee_percentage",modelValue:s(e).bpjs_employee_percentage,"onUpdate:modelValue":o[6]||(o[6]=l=>s(e).bpjs_employee_percentage=l),type:"number",step:"0.01",class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,8,["modelValue"]),t(n,{message:s(e).errors.bpjs_employee_percentage,class:"mt-2 text-sm text-red-600"},null,8,["message"])])])):U("",!0),r("div",null,[t(m,{for:"benefits",value:"Benefits",class:"block text-sm font-medium text-gray-700"}),i(r("textarea",{id:"benefits","onUpdate:modelValue":o[7]||(o[7]=l=>s(e).benefits=l),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"},null,512),[[w,s(e).benefits]]),t(n,{message:s(e).errors.benefits,class:"mt-2 text-sm text-red-600"},null,8,["message"])]),r("div",M,[t(h,{disabled:u.value&&s(e).isDirty,class:"inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:B(()=>o[9]||(o[9]=[N(" Save ")])),_:1},8,["disabled"])])],32)]))}};export{O as default};
