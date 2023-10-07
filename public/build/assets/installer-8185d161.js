import{_ as v,a as h,c as n,b as a,l as p,t as d,j as i,n as u,w as m,v as c,g as b,F as w,r as y,o as r,s as f,u as k}from"./_plugin-vue_export-helper-77894273.js";const C={name:"Installer",props:{},data(){return console.log({VITE_EN_APP_NAME:"al3iadah",BASE_URL:"/build/",MODE:"production",DEV:!1,PROD:!0,SSR:!1}),{errors:[],script_name:"al3iadah",login_url:window.installer.login_url,error_message:"",name:null,loader:!1,permissions_page:!1,permissions_button:!1,complete_installation_button:!1,requirements_page:!1,complete_installation_page:!1,page:"",app_name:"al3iadah",app_timezone:null,database_connection:1,database_host:"localhost",database_port:"3306",database_name:"clinic",database_user_name:"homestead",database_password:"secret",connection_exists:!1,finished:!1,finalEnvFile:null,finalStatusMessage:null,finalMessages:null,dbOutputLog:null,is_sub_directory:window.installer.is_sub_directory,timezones:window.installer.timezones,host:window.installer.host}},methods:{requirements(){this.loader=!0,h.get(window.installer.requirements_url).then(l=>{this.loader=!1,this.page=l.data.html,this.requirements_page=!0,l.data.status&&(this.permissions_button=!0)}).catch(l=>{this.loader=!1,this.error_message="Something Went Wrong"})},permissions(){this.loader=!0,h.get(window.installer.permissions_url).then(l=>{this.requirements_page=!1,this.permission_page=!0,this.page=l.data.html,this.loader=!1,l.data.status&&(this.complete_installation_button=!0)}).catch(l=>{this.loader=!1,this.error_message="Something Went Wrong"})},testConnection(){if(this.validator("test_db")){this.loader=!0;const t={database_connection:this.database_connection==1?"mysql":this.database_connection==2?"pgsql":"null",database_hostname:this.database_host,database_port:this.database_port,database_name:this.database_name,database_user_name:this.database_user_name,database_password:this.database_password};h.post(window.installer.test_connection_url,t).then(s=>{s.data&&s.data.status_code&&s.data.status_code==200?this.connection_exists=!0:s.data&&s.data.status_code&&s.data.status_code==422&&s.data.errors?this.errors.database_connection=s.data.errors.database_connection[0]:this.error_message="Could not connect to the database",this.loader=!1}).catch(s=>{this.loader=!1,this.error_message="Could not connect to the database"})}},completeInstallation(){if(this.validator("test_db",!0)){this.loader=!0;const t={app_name:this.app_name,app_timezone:this.app_timezone,database_connection:this.database_connection==1?"mysql":this.database_connection==2?"pgsql":"null",database_hostname:this.database_host,database_port:this.database_port,database_name:this.database_name,database_username:this.database_user_name,database_password:this.database_password};h.post(window.installer.complete_installation_url,t).then(s=>{s.data&&s.data.status_code&&s.data.status_code==422&&s.data.errors?(console.log("422"),s.data.errors.app_name&&(this.errors.app_name=s.data.errors.app_name[0]),s.data.errors.app_timezone&&(this.errors.app_timezone=s.data.errors.app_timezone[0]),s.data.errors.database_connection&&(this.errors.database_connection=s.data.errors.database_connection[0]),s.data.errors.database_hostname&&(this.errors.database_host=s.data.errors.database_hostname[0]),s.data.errors.database_port&&(this.errors.database_port=s.data.errors.database_port[0]),s.data.errors.database_name&&(this.errors.database_name=s.data.errors.database_name[0]),s.data.errors.database_username&&(this.errors.database_user_name=s.data.errors.database_username[0]),s.data.errors.database_password&&(this.errors.database_password=s.data.errors.database_password[0])):s.data&&s.data.status_code&&s.data.status_code==500?(console.log("500"),this.error_message=s.data.errors):s.data&&s.data.status_code&&s.data.status_code==200?(console.log("200"),this.dbOutputLog=s.data.dbOutputLog,this.finalMessages=s.data.final.finalMessages,this.finalStatusMessage=s.data.final.finalStatusMessage,this.finalEnvFile=s.data.final.finalEnvFile,this.finished=!0):this.error_message="Something went wrong",this.loader=!1}).catch(s=>{this.error_message="Something went wrong",this.loader=!1})}},valuesChangedAfterTest(){this.connection_exists=!1},changeDBConnection(){this.connection_exists=!1,this.database_connection==1?(this.database_port=="5432"&&(this.database_port="3306"),this.database_user_name=="postgres"&&(this.database_user_name="root")):this.database_connection==2&&(this.database_port=="3306"&&(this.database_port=5432),this.database_user_name=="root"&&(this.database_user_name="postgres"))},completeInstallationPage(){this.permission_page=!1,this.complete_installation_page=!0},validator(l,t=!1){this.error_message=null,this.errors=[];let s=!1;return l=="test_db"&&(this.database_connection||(this.errors.database_connection="Database Connection required.",s=!0),this.database_host||(this.errors.database_host="Database Host  required.",s=!0),this.database_port||(this.errors.database_port="Database Port required.",s=!0),this.database_name||(this.errors.database_name="Database Name required.",s=!0),this.database_user_name||(this.errors.database_user_name="Database User Name required.",s=!0),t&&(this.app_name||(this.errors.app_name="App Name required.",s=!0)),this.app_timezone||(this.errors.app_timezone="App Timezone required.",s=!0)),!s}}},D={key:0,class:"alert alert-danger",id:"error_alert"},q={style:{margin:"0",color:"#fff","font-size":"15px","line-height":"1.6em"}},z=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),x={key:1},A=["innerHTML"],I={key:3,class:"loader"},M={class:"buttons"},S={key:4,class:"tabs tabs-full"},N={key:0},T={key:0},E=a("p",null,[a("strong",null,[a("small",null,"Migration & Seed Console Output:")])],-1),V=a("p",null,[a("strong",null,[a("small",null,"Application Console Output:")])],-1),U=a("p",null,[a("strong",null,[a("small",null,"Installation Log Entry:")])],-1),P=a("p",null,[a("strong",null,[a("small",null,"Final .env File:")])],-1),F={class:"buttons"},L=["href"],O={key:1},B=a("input",{id:"tab1",type:"radio",name:"tabs",class:"tab-input",checked:""},null,-1),H={key:0,class:"alert alert-danger",id:"error_alert",style:{background:"#6fe373"}},W=a("h6",{style:{margin:"0",color:"#fff","font-size":"15px","line-height":"1.6em"}}," Database connection tested successfully ",-1),R=[W],j={class:"tabs-wrap"},G={class:"tab",id:"tab1content"},J=a("input",{type:"hidden",name:"_token",value:"{{ window.laravel }}"},null,-1),K=a("label",{for:"app_name"}," App Name ",-1),Q={key:0,class:"error-block"},X=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),Y=a("label",{for:"app_timezone"}," App Timezone ",-1),Z=["value"],$={key:0,class:"error-block"},ee=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),ae=a("label",{for:"database_connection"}," Database Connection ",-1),se=a("option",{value:"1"},"mysql",-1),te=a("option",{value:"2"},"pgsql",-1),oe=[se,te],ne={key:0,class:"error-block"},re=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),ie=a("label",{for:"database_hostname"}," Database Host ",-1),le={key:0,class:"error-block"},de=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),_e=a("label",{for:"database_port"}," Database Port ",-1),pe={key:0,class:"error-block"},ue=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),me=a("label",{for:"database_name"}," Database Name ",-1),ce={key:0,class:"error-block"},he=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),be=a("label",{for:"database_username"}," Database User Name ",-1),fe={key:0,class:"error-block"},ge=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),ve=a("label",{for:"database_password"}," Database Password ",-1),we={key:0,class:"error-block"},ye=a("i",{class:"fa fa-fw fa-exclamation-triangle","aria-hidden":"true"},null,-1),ke={key:0,class:"loader"},Ce={key:1,class:"buttons"};function De(l,t,s,ze,e,_){return r(),n("div",null,[e.error_message?(r(),n("div",D,[a("h6",q,[z,p(" "+d(e.error_message),1)])])):i("",!0),!e.requirements_page&&!l.permission_page&&!e.complete_installation_page?(r(),n("p",x," Welome at "+d(e.script_name)+" installer , this is easy installer to help you install "+d(e.script_name)+" in few easy steps ",1)):i("",!0),e.requirements_page||l.permission_page?(r(),n("span",{key:2,innerHTML:e.page},null,8,A)):i("",!0),e.loader&&(e.requirements_page||l.permission_page)?(r(),n("div",I)):i("",!0),a("div",M,[e.requirements_page&&e.permissions_button&&!e.loader?(r(),n("a",{key:0,class:"button",onClick:t[0]||(t[0]=o=>_.permissions())}," Check Directories Permissions ")):i("",!0),!e.requirements_page&&!l.permission_page&&!e.complete_installation_page?(r(),n("a",{key:1,class:"button",onClick:t[1]||(t[1]=o=>_.requirements())}," Start instalation ")):i("",!0),l.permission_page&&e.complete_installation_button&&!e.loader?(r(),n("a",{key:2,class:"button",onClick:t[2]||(t[2]=o=>_.completeInstallationPage())}," Configure Environment ")):i("",!0),l.permission_page&&!e.complete_installation_button&&!e.loader?(r(),n("a",{key:3,class:"button",onClick:t[3]||(t[3]=o=>_.permissions())}," Retry ")):i("",!0)]),e.complete_installation_page?(r(),n("div",S,[e.finished?(r(),n("div",N,[e.finished?(r(),n("h6",T," Installation Finished")):i("",!0),E,a("pre",null,[a("code",null,d(e.dbOutputLog),1)]),V,a("pre",null,[a("code",null,d(e.finalMessages),1)]),U,a("pre",null,[a("code",null,d(e.finalStatusMessage),1)]),P,a("pre",null,[a("code",null,d(e.finalEnvFile),1)]),a("div",F,[a("a",{href:e.login_url,class:"button"},"Click here to exit",8,L)])])):i("",!0),e.finished?i("",!0):(r(),n("div",O,[B,e.connection_exists?(r(),n("div",H,R)):i("",!0),a("form",j,[a("div",G,[J,a("div",{class:u(["form-group",{"has-error":e.errors.app_name}])},[K,m(a("input",{type:"text",name:"app_name",id:"app_name","onUpdate:modelValue":t[4]||(t[4]=o=>e.app_name=o),placeholder:"App Name"},null,512),[[c,e.app_name]]),e.errors.app_name?(r(),n("span",Q,[X,p(" "+d(e.errors.app_name),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.app_timezone}])},[Y,m(a("select",{name:"app_timezone",id:"app_timezone","onUpdate:modelValue":t[5]||(t[5]=o=>e.app_timezone=o)},[(r(!0),n(w,null,y(e.timezones,o=>(r(),n("option",{value:o},d(o),9,Z))),256))],512),[[b,e.app_timezone]]),e.errors.app_timezone?(r(),n("span",$,[ee,p(" "+d(e.errors.app_timezone),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_connection}])},[ae,m(a("select",{name:"database_connection",id:"database_connection","onUpdate:modelValue":t[6]||(t[6]=o=>e.database_connection=o),onChange:t[7]||(t[7]=o=>_.changeDBConnection())},oe,544),[[b,e.database_connection]]),e.errors.database_connection?(r(),n("span",ne,[re,p(" "+d(e.errors.database_connection),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_host}])},[ie,m(a("input",{type:"text",name:"database_hostname",id:"database_hostname","onUpdate:modelValue":t[8]||(t[8]=o=>e.database_host=o),placeholder:"Database Host",onInput:t[9]||(t[9]=o=>_.valuesChangedAfterTest())},null,544),[[c,e.database_host]]),e.errors.database_host?(r(),n("span",le,[de,p(" "+d(e.errors.database_host),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_port}])},[_e,m(a("input",{type:"number",name:"database_port",id:"database_port","onUpdate:modelValue":t[10]||(t[10]=o=>e.database_port=o),placeholder:"Database Port",onInput:t[11]||(t[11]=o=>_.valuesChangedAfterTest())},null,544),[[c,e.database_port]]),e.errors.database_port?(r(),n("span",pe,[ue,p(" "+d(e.errors.database_port),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_name}])},[me,m(a("input",{type:"text",name:"database_name",id:"database_name","onUpdate:modelValue":t[12]||(t[12]=o=>e.database_name=o),placeholder:"Database Name",onInput:t[13]||(t[13]=o=>_.valuesChangedAfterTest())},null,544),[[c,e.database_name]]),e.errors.database_name?(r(),n("span",ce,[he,p(" "+d(e.errors.database_name),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_user_name}])},[be,m(a("input",{type:"text",name:"database_username",id:"database_username","onUpdate:modelValue":t[14]||(t[14]=o=>e.database_user_name=o),placeholder:"Database User Name",onInput:t[15]||(t[15]=o=>_.valuesChangedAfterTest())},null,544),[[c,e.database_user_name]]),e.errors.database_user_name?(r(),n("span",fe,[ge,p(" "+d(e.errors.database_user_name),1)])):i("",!0)],2),a("div",{class:u(["form-group",{"has-error":e.errors.database_password}])},[ve,m(a("input",{type:"password",name:"database_password",id:"database_password","onUpdate:modelValue":t[16]||(t[16]=o=>e.database_password=o),placeholder:"Database Password",onInput:t[17]||(t[17]=o=>_.valuesChangedAfterTest())},null,544),[[c,e.database_password]]),e.errors.database_password?(r(),n("span",we,[ye,p(" "+d(e.errors.database_password),1)])):i("",!0)],2),e.loader?(r(),n("div",ke)):i("",!0),e.loader?i("",!0):(r(),n("div",Ce,[e.connection_exists?i("",!0):(r(),n("button",{key:0,class:"button",type:"button",onClick:t[18]||(t[18]=o=>_.testConnection())}," Test DB Connection ")),e.connection_exists?(r(),n("button",{key:1,class:"button",type:"button",onClick:t[19]||(t[19]=o=>_.completeInstallation())}," Install ")):i("",!0)]))])])]))])):i("",!0)])}const qe=v(C,[["render",De]]);window.__=f;const g=k({provide:{__:f}});g.component("installer",qe);g.mount("#installer");
