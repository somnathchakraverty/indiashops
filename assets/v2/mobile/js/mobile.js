var CONTENT = {
    "uri" : '',
    "force" : false,
    "owl"   : true,
    "pid" : '',
    f : function(force){
        this.force = force;
        return this;
    },
    load : function( section, owl, post, callback )
    {
        this.get(section, owl, post, callback);
    },
    append : function( content, section )
    {
        if( content.length > 0 )
        {
            try {
                content = JSON.parse(content)
            }
            catch(e){}

            if(typeof content == 'string')
            {
                $( "#"+section ).html( content );
                $( "#"+section+"-wrapper" ).hide().fadeIn("slow");
            }
            else if(typeof content == 'object' )
            {
                $.each(content,function(section,val){
                    $( "#"+section ).html( val );
                    $( "#"+section+"-wrapper" ).hide().fadeIn("slow");
                });
            }
            // $( "#"+section ).html( content ).show();
        }
        else
        {
            $( "#"+section ).html('').closest("#"+section+'-wrapper').hide();
        }
    },
    get : function( section, owl, post, callback )
    {
        url = this.uri+"/"+section;
        that = this;

        if( content = this.hasLocal(section+that.pid) )
        {
            if( section == "all" )
            {
                content =  $.parseJSON(content);
                $.each( content, function( sec, cont ){

                    that.append(cont,sec);
                    if(owl)
                    {
                        setTimeout(function(){
                            that.refresh(sec);
                        },500);
                    }

                    if( typeof(callback) == "function" )
                    {
                        callback();
                    }
                });
            }
            else
            {
                that.append(content,section);

                if(owl)
                {
                    setTimeout(function(){
                        that.refresh(section);
                    },500);
                }

                if( typeof(callback) == "function" )
                {
                    callback();
                }
            }
        }
        else
        {
            if( typeof post != 'undefined' )
            {
                if(typeof post.product != 'undefined')
                    url = url+"?content="+post.product

                $.get( url, function( content ){

                    that.addToCache( section, content );
                    that.append(content,section);
                    if(owl)
                    {
                        setTimeout(function(){
                            that.refresh(section);
                        },500);
                    }

                    if( typeof(callback) == "function" )
                    {
                        callback();
                    }
                });
            }
            else
            {
                $.get( url, function( content ){

                    that.addToCache( section, content );
                    that.append(content,section);
                    if(owl)
                    {
                        setTimeout(function(){
                            that.refresh(section);
                        },500);
                    }

                    if( typeof(callback) == "function" )
                    {
                        callback();
                    }
                });
            }
        }
    },
    addToCache: function( section, content )
    {
        if( content.length > 0 )
        {
            try{
                localStorage.setItem( section+this.pid, content );
                localStorage.setItem( "date"+section, new Date().getTime() );
            }
            catch(e)
            {
                localStorage.clear();
                localStorage.setItem( section+this.pid, content );
                localStorage.setItem( "date"+section, new Date().getTime() );
            }
        }
    },
    refresh: function( section )
    {
        var el = $("#"+section);

        if( el.is(':empty') )
        {
            el.closest("#"+section+"-wrapper").parent().hide();
        }
        else
        {
            $("#"+section+"-slider").flexisel();
        }
    },
    hasLocal: function( section )
    {
        if( typeof localStorage == "object" )
        {
            updated = localStorage.getItem( "date"+section );
            now     = new Date().getTime();
            //345600000
            //1462783862844, 1462438262844
            ms = Math.abs( parseInt(now) - parseInt(updated) );

            if( ms != NaN && numDays(ms) > 2 && !this.force )
            {
                return false;
            }
            else
            {
                data = localStorage.getItem(section);

                if( data != null && !this.force )
                {
                    return data;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    },
};
function numDays( ms )
{
    return Math.round( (((ms/1000)/60)/60)/24 );
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'ig'), replacement);
};