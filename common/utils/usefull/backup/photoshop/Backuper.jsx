var Backuper = function(maxFileSize){
         
         //Vérifier si un document est ouvert
         if(app.documents.length > 0 && app.activeDocument ){
             
            this._maxFileSize = parseInt(maxFileSize); 
            this._doc = app.activeDocument; 
            this._printMode = 'dec';
            this._sizeFound = false;
            this._sets = this._doc.layerSets;
            this._artLayers = this._doc.artLayers;
            this._currentSet = null;
            this._currentName = "";
            this._currentGrpName = "";
            
            if(this._sets.length > 0){
                 this._currentSet = 0;
            }
                    
            //Sauver le document
            if(!this._doc.saved){
                if(this._doc.name.indexOf('.') === -1){
                    var file = new File('~/Desktop/'+this._doc.name+'.psd');
                    var saveFile = file.saveDlg(null, "Photoshop:*.psd");
                    if(saveFile == null || saveFile == undefined){
                        throw new Error('No location selected.');
                    }
                    this._doc.saveAs(saveFile, new PhotoshopSaveOptions());
                } else {
                     this._doc .save();
                }
            }
         } else {
             throw new Error('No documents are opened.');
        }
    
        this.hideAll();
        this._historyState = app.activeDocument.activeHistoryState; 
    }

    Backuper.prototype.processing = function() {
         var setsLength = this._sets.length;
         var artLength = this._artLayers.length;
         
         if(setsLength > 0){
             var currentSet = null;
             this.deSelectLayerMaskAndSelectImageLayer();

             for(var i = 0; i < setsLength; i++){
                 
                var name = this._sets[i].name;
                var artLayersLength = this._sets[i].artLayers.length;
                var currentLayer = null;
                                
                if(i > 0){
                        this._sets[(i - 1)].visible = false;
                }
                this._sets[i].visible = true;

                for(var i2 = 0; i2 < artLayersLength; i2++){
                     if(i2 > 0){
                         
                        this._sets[i].artLayers[(i2 - 1)].visible = false;
                     }
                     this._sets[i].artLayers[i2].visible = true;
                     this._doc.activeLayer = this._sets[i].artLayers[i2];
                    
                     //print//
                     this._historyState = app.activeDocument.activeHistoryState; 
                     this.trimByUniColor(true);
                     this.print(100,  this._sets[i].name);
                     this._sizeFound = false;
                     this._printMode = 'dec';
                     app.activeDocument.activeHistoryState =  this._historyState; 
                    this._sets[i].artLayers[i2].name = this._currentName;
                     currentLayer = this._sets[i].artLayers[i2];
                }
               currentLayer.visible = false;
               this._sets[i].name = this._currentGrpName;
               currentSet = this._sets[i];
             }
             currentSet.visible = false;
         }
     
         if(artLength > 0){
             var currentAL = null;
             this.deSelectLayerMaskAndSelectImageLayer();

             for(var i = 0; i < artLength; i++){
                if(!this._artLayers[i].isBackgroundLayer){
                    var name = this._artLayers[i].name;
                                    
                    if(i > 0){
                            this._artLayers[(i - 1)].visible = false;
                    }
                    this._artLayers[i].visible = true;
                    this._doc.activeLayer = this._artLayers[i];
                    
                    //print//
                    this._historyState = app.activeDocument.activeHistoryState; 
                    this.trimByUniColor(true);
                    this.print(100);
                    this._sizeFound = false;
                    this._printMode = 'dec';
                    app.activeDocument.activeHistoryState =  this._historyState;
                    this._artLayers[i].name = this._currentName;
                    currentAL = this._artLayers[i];
                 }
             }
            if(currentAL !== null){
                currentAL.visible = false;
                 $.writeln(currentAL);
            } else {
               /* $.writeln('currentAL is null.');*/
            
            }
         }
         this.deSelectLayerMaskAndSelectImageLayer();                     
         this.deSelect();
    }

    Backuper.prototype.clean = function() {
         var setsLength = this._sets.length;
         var artLength = this._artLayers.length;
         this._historyState = app.activeDocument.activeHistoryState; 
         
         if(setsLength > 0){
             this.deSelectLayerMaskAndSelectImageLayer();            
             for(var i = 0; i < setsLength; i++){
                var artLayersLength = this._sets[i].artLayers.length;
                this._sets[i].visible = true;

                for(var i2 = 0; i2 < artLayersLength; i2++){
                     this._sets[i].artLayers[i2].visible = true;
                     this._doc.activeLayer = this._sets[i].artLayers[i2];
                     this.trimByUniColor(false);
                }
             }
         }
     
         if(artLength > 0){
             this.deSelectLayerMaskAndSelectImageLayer();             
             for(var i = 0; i < artLength; i++){
                if(!this._artLayers[i].isBackgroundLayer){
                    this._artLayers[i].visible = true;
                    this._doc.activeLayer = this._artLayers[i];
                    this.trimByUniColor(false);
                 }
             }
         }
         this.deSelectLayerMaskAndSelectImageLayer();                     
         this.deSelect();
    }
    
    Backuper.prototype.trimByUniColor = function(crop){
        crop = crop === undefined ? true : crop;
        
        var idslct = charIDToTypeID( "slct" );
        var desc78 = new ActionDescriptor();
        var idnull = charIDToTypeID( "null" );
        var ref75 = new ActionReference();
        var idmagicWandTool = stringIDToTypeID( "magicWandTool" );
        ref75.putClass( idmagicWandTool );
        desc78.putReference( idnull, ref75 );
        var iddontRecord = stringIDToTypeID( "dontRecord" );
        desc78.putBoolean( iddontRecord, true );
        var idforceNotify = stringIDToTypeID( "forceNotify" );
        desc78.putBoolean( idforceNotify, true );
        executeAction( idslct, desc78, DialogModes.NO );
        var idsetd = charIDToTypeID( "setd" );
        var desc79 = new ActionDescriptor();
        var idnull = charIDToTypeID( "null" );
        var ref76 = new ActionReference();
        var idChnl = charIDToTypeID( "Chnl" );
        var idfsel = charIDToTypeID( "fsel" );
        ref76.putProperty( idChnl, idfsel );
        desc79.putReference( idnull, ref76 );
        var idT = charIDToTypeID( "T   " );
        var desc80 = new ActionDescriptor();
        var idHrzn = charIDToTypeID( "Hrzn" );
        var idPxl = charIDToTypeID( "#Pxl" );
        desc80.putUnitDouble( idHrzn, idPxl, 0.000000 );
        var idVrtc = charIDToTypeID( "Vrtc" );
        var idPxl = charIDToTypeID( "#Pxl" );
        desc80.putUnitDouble( idVrtc, idPxl, 0.000000 );
        var idPnt = charIDToTypeID( "Pnt " );
        desc79.putObject( idT, idPnt, desc80 );
        var idTlrn = charIDToTypeID( "Tlrn" );
        desc79.putInteger( idTlrn, 1 );
        executeAction( idsetd, desc79, DialogModes.NO );
        var idDlt = charIDToTypeID( "Dlt " );
        executeAction( idDlt, undefined, DialogModes.NO );

       if(crop){
            app.activeDocument.trim();
        }
        
        $.sleep(100);
    }

    Backuper.prototype.deSelect = function() {
        var idsetd = charIDToTypeID( "setd" );
        var desc83 = new ActionDescriptor();
        var idnull = charIDToTypeID( "null" );
        var ref79 = new ActionReference();
        var idChnl = charIDToTypeID( "Chnl" );
        var idfsel = charIDToTypeID( "fsel" );
        ref79.putProperty( idChnl, idfsel );
        desc83.putReference( idnull, ref79 );
        var idT = charIDToTypeID( "T   " );
        var idOrdn = charIDToTypeID( "Ordn" );
        var idNone = charIDToTypeID( "None" );
        desc83.putEnumerated( idT, idOrdn, idNone );
        executeAction( idsetd, desc83, DialogModes.NO );
    }

    Backuper.prototype.deSelectLayerMaskAndSelectImageLayer = function() {
        var id248 = charIDToTypeID( "slct" );
        var desc48 = new ActionDescriptor();
        var id249 = charIDToTypeID( "null" );
        var ref36 = new ActionReference();
        var id250 = charIDToTypeID( "Chnl" );
        var id251 = charIDToTypeID( "Chnl" );
        var id252 = charIDToTypeID( "RGB " );
        ref36.putEnumerated( id250, id251, id252 );
        desc48.putReference( id249, ref36 );
        var id253 = charIDToTypeID( "MkVs" );
        desc48.putBoolean( id253, false );
        executeAction( id248, desc48, DialogModes.NO );
    }


    Backuper.prototype.hideAll = function(set) {
         set = (set != undefined && set.constructor.name == 'LayerSet') ? set : this._doc;
         var layersLength = set.layers.length;
         if(layersLength > 0){
             for(var i = 0; i < layersLength; i++){
                var layer = set.layers[i];
                if(layer.constructor.name == 'LayerSet') {
                    $.writeln('LayerSet : '+layer.name);
                   this.hideAll(layer);
                } else {
                     $.writeln('ArtLayer : '+layer.name);
                    layer.visible = false;
                }
             }
         }
     
         if(set.constructor.name == 'LayerSet') {
            set.visible = false;
         }
    }

    Backuper.prototype.print = function(quality, name) {
        var exportOptions = new ExportOptionsSaveForWeb();
              exportOptions.format = SaveDocumentType.JPEG;
              exportOptions.quality = quality;
              exportOptions.optimized = true;
              
         var folderName = app.activeDocument.path + '/images-backup';
         var folder = new Folder(folderName) ;
         if (! folder.exists) {
             folder.create();  
         }
     
        if(name != undefined){
            var grp_name = name.replace(/\s/gi, '-');
                  grp_name = grp_name.replace(/[^a-z0-9_-]/gi, '_');
                  
           this._currentGrpName = grp_name;
                  
            var folder_grp = new Folder(folderName+'/'+grp_name) ;
             if (! folder_grp.exists) {
                 folder_grp.create();  
             }

            this._currentName = grp_name+'-'+parseInt(this._doc.width)+'x'+parseInt(this._doc.height);
            var saveFile = new File(folderName+'/'+grp_name+'/'+this._currentName+'.jpg');
            app.activeDocument.exportDocument(saveFile, ExportType.SAVEFORWEB, exportOptions);
            
        } else {
            var new_name = app.activeDocument.name.substring(0, app.activeDocument.name.indexOf('.')).replace(/\s/gi, '-');
                   new_name = new_name.replace(/[^a-z0-9_-]/gi, '_');
             this._currentName = new_name+'-'+parseInt(this._doc.width)+'x'+parseInt(this._doc.height);
             var saveFile = new File(folderName+'/'+this._currentName+'.jpg');
             app.activeDocument.exportDocument(saveFile, ExportType.SAVEFORWEB, exportOptions);
        }
        if(!this._sizeFound){
            if(this._printMode === "dec"){
                if(Math.ceil(saveFile.length / 1024) >= this._maxFileSize && quality > 1) {
                    if(quality < 10){
                         this.print(1, name);    
                    } else {
                        this.print(quality - 10, name);    
                    }
                 } else {
                     if(quality > 1) {
                         this._printMode = "inc";
                         if(quality < 100){
                            this.print(quality + 1, name);   
                         }
                     } else {
                         this._sizeFound = true;
                     }
                 }
             } else if(this._printMode  === "inc") {
                 if(Math.ceil(saveFile.length / 1024) <= this._maxFileSize && quality < 100) {
                     this.print(quality + 1, name);   
                  } else {
                     this._sizeFound = true;
                     if(quality > 2) {
                            this.print(quality - 1, name);   
                     }
                  }
              }
           }
    }


        var startRulerUnits = app.preferences.rulerUnits;
    app.preferences.rulerUnits = Units.PIXELS;
    app.bringToFront();   
    
    var value = prompt("Write the limit size.", 39); 

  try {
        var bck = new Backuper(parseInt(value));
        bck.processing();
        bck.clean();
    } catch(e){
        alert(e.message);
    }
   
   
   
   
