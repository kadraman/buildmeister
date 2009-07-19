var FilterTable = new Class(
{
    Implements : [ Events, Options ],
        options: {
            addurl: "",
            editurl: "",
            deleteurl: "",
            sortCol: "",
            sortDir: "",
            singleSelect: false,
            perPage: 20,            
            width: 0,
            height: 0
        },
        
    /*
     * initialize
     */
    initialize: function(container, url, key, headers, options) {
        this.setOptions(options);
        this.container = $(container);
        this.url = url;
        this.key = key;
        this.headers = headers;
        this.sortColumn = this.options.sortCol;
        this.sortDirection = this.options.sortDir;
        this.rowsPerPage = this.options.perPage;
        
        this.curPage = 1;       // the current page
        this.maxPages = 1;      // the maximum number of pages
        this.prevPage = 1;      // the previous page
        this.nextPage = 1;      // the next page
        this.numEntries = 0;    // the number of entries found
        this.keyIndex = 0;      // the column containing the field used for editing
        this.numCols = 0;       // the number of columns in the table
        this.busy = false; 
        this.rowSelected = false; // boolean to indicate whether a row has been selected
        
        // create the table
        this.createTable();
        // and load some data
        this.requestData(this.curPage);
    }, // end of initialize    
           
    /*
     * createTable: create the outline table structure
     */
    createTable: function() {
        var structureHTML = 
              "<div id=\"tableNavigation\" class=\"tableNav\">"
            + "</div>"
            + "<div id=\"tableContent\">" 
            +     "<table class=\"filter-table\">" 
            +         "<thead><tr></tr></thead>"
            +         "<tbody></tbody>"
            +         "<tfoot><tr></tr></tfoot>"
            +     "</table>"
            +     "</div>";
                
        // create the basic structure
        this.container.set('html', structureHTML);
                
        // grab the important elements
        this.tableContent = $('tableContent');
        this.table = this.tableContent.getChildren("table")[0];
        this.tableNav = $("tableNavigation");
        this.tableBody = this.table.getChildren("tbody")[0];
        this.tableHead = this.table.getChildren("thead")[0];
        this.tableHeadTr = this.tableHead.getChildren("tr")[0];
        this.tableFoot = this.table.getChildren('tfoot')[0];
        this.tableFootTr = this.tableFoot.getChildren("tr")[0];      
        
        // set height and width of table if specified
        if (this.options.width != 0) {
            this.tableContent.setStyle('width', this.options.width + "px");
        }
        if (this.options.height != 0) {
            this.tableContent.setStyle('height', this.options.height + "px");
            this.tableContent.setStyle('overflow', 'auto');
        }
           
        // create the navigation bar
        this.createNavigation();
        
        // where we will place the filterable fields
        this.filterSelect = this.tableNav.getChildren("select")[0];
        
        // create the table header row
        this.createHeader();
    }, // end of createTable
            
    /*
     * createNavigation: create the navigation bar
     */
    createNavigation: function() {
        
        // create add item link
        var addLink = new Element('a', {
            'id': 'addLink',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (addLink.hasClass('iconSelectable')) {
                        addLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                    }
                },
                'mouseleave': function() {
                    if (addLink.hasClass('iconHighlighted')) {
                        addLink.removeClass('iconHighlighted').addClass('iconSelectable');  
                    }
                },
                'click': function() {
                    if (this.options.addurl != "") {
                        // redirect to add page
                        window.location = this.options.addurl;
                    }
                    return false;
                }.bind(this)
            }
        });   
        addLink.addClass('iconSelectable');
        addLink.inject(this.tableNav);        
        var addLinkImage = new Element('img', {
            'id': 'addIcon',
            'src': CONFIG['image_dir'] + '/filtertable-add.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            }
        });        
        addLinkImage.inject(addLink);        
        var addLinkLabel = new Element('label', {
            'id': 'addLabel',
            'html': 'Add',
            'styles': {
                'margin-left': '2px',
                'margin-right': '2px'
            }    
        });
        addLinkLabel.inject(addLink);
        if (this.options.addurl == "") addLink.addClass('iconUnselectable');
        else addLink.addClass('iconSelectable');
        
        // edit an item link
        var editLink = new Element('a', {
            'id': 'editLink',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (editLink.hasClass('iconSelectable')) {
                        editLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                    }
                },
                'mouseleave': function() {
                    if (editLink.hasClass('iconHighlighted')) {
                        editLink.removeClass('iconHighlighted').addClass('iconSelectable');  
                    }
                },
                'click': function() {
                    if (this.options.editurl != "") {
                        numSelected = $$('tr.selected').length;
                        if (numSelected == 0) {
                            // ignore
                        } else if (numSelected > 1) {
                            alert("Only one item can be edited at a time.");
                        } else {
                            // TODO: only get the one element
                            $$('tr.selected').each(function(tr) {
                                window.location = tr.getChildren("td")[this.keyIndex].getChildren("a")[0].get('href');
                            }, this);
                        }                       
                    }
                    return false;
                }.bind(this)
            }
        });       
        editLink.inject(this.tableNav);        
        var editLinkImage = new Element('img', {
            'id': 'editIcon',
            'src': CONFIG['image_dir'] + '/filtertable-edit-grey.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        editLinkImage.inject(editLink);        
        var editLinkLabel = new Element('label', {
            'id': 'editLabel',
            'html': 'Edit',
            'styles': {
                'margin-left': '2px',
                'margin-right': '2px'
            }    
        });
        editLinkLabel.inject(editLink);
        editLink.addClass('iconUnselectable');
        
        // delete item link
        var deleteLink = new Element('a', {
            'id': 'deleteLink',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (deleteLink.hasClass('iconSelectable')) {
                        deleteLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                    }
                },
                'mouseleave': function() {
                    if (deleteLink.hasClass('iconHighlighted')) {
                        deleteLink.removeClass('iconHighlighted').addClass('iconSelectable');  
                    }
                },
                'click': function(e) {
                    e.preventDefault();
                    if (this.options.deleteurl == "")
                        alert("This option is not yet implemented");
                    else {
                        numSelected = $$('tr.selected').length;
                        if (numSelected > 0) {
                            if (confirm('Are you sure you want to delete ' + numSelected + ' row(s)?')) {                                                      
                                $$('tr.selected').each(function(tr) {
                                    deleteId = tr.getChildren("td")[0].get('id');   
                                    deleteSuccess = true;
                                    // delete the users via AJAX
                                    // TODO: delete as a single transactions
                                    var req = new Request({
                                        method: 'post',
                                        url: this.options.deleteurl,
                                        data: { 'id' : deleteId },
                                        onComplete: function(response) { 
                                            // decode the JSON response
                                            var status = JSON.decode(response);
                                            // act on the response
                                            if (!status.code) {
                                                alert("Error: " + status.message);
                                                deleteSuccess = false;
                                            } 
                                        }   
                                    }).send();
                                }, this);
                                // reload the page
                                if (deleteSuccess) alert("Succesfully Deleted " + numSelected + " rows");
                                this.requestData(this.curPage);                                 
                            }
                        }
                    }
                    return false;
                }.bind(this)
            }
        });  
        deleteLink.inject(this.tableNav);        
        var deleteLinkImage = new Element('img', {
            'id': 'deleteIcon',
            'src': CONFIG['image_dir'] + '/filtertable-del-grey.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        deleteLinkImage.inject(deleteLink);        
        var deleteLinkLabel = new Element('label', {
            'id': 'deleteLabel',
            'html': 'Delete',
            'styles': {
                'margin-left': '2px',
                'margin-right': '2px'
            }    
        });
        deleteLinkLabel.inject(deleteLink);
        deleteLink.addClass('iconUnselectable');
        
        // separator
        var separator1 = new Element('label', {
            'id': 'separator1',
        });
        separator1.addClass('iconSeparator');
        separator1.inject(this.tableNav);        
        
        // first item link
        var firstLink = new Element('a', {
            'id': 'firstButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (this.curPage != 1) {
                        if (firstLink.hasClass('iconSelectable'))
                            firstLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                        else if (firstLink.hasClass('iconUnselectable'))
                            firstLink.removeClass('iconUnselectable').addClass('iconHighlighted');
                    }
                }.bind(this),
                'mouseleave': function() {
                    if (firstLink.hasClass('iconHighlighted'))
                        firstLink.removeClass('iconHighlighted').addClass('iconSelectable'); 
                }.bind(this),
                'click': function() {
                    if (this.curPage > 1) {
                        this.requestData(1);
                        firstLink.removeClass('iconHighlighted').addClass('iconUnselectable');
                    }
                    return false;
                }.bind(this)
            }
        });        
        firstLink.addClass('iconSelectable');
        firstLink.inject(this.tableNav);        
        var firstLinkImage = new Element('img', {
            'id': 'firstIcon',
            'src': CONFIG['image_dir'] + '/filtertable-first.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        firstLinkImage.inject(firstLink);  
        
        // previous item link
        var prevLink = new Element('a', {
            'id': 'prevButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (this.curPage != 1) {
                        if (prevLink.hasClass('iconSelectable'))
                            prevLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                        else if (prevLink.hasClass('iconUnselectable'))
                            prevLink.removeClass('iconUnselectable').addClass('iconHighlighted');
                    }
                }.bind(this),
                'mouseleave': function() {
                    if (prevLink.hasClass('iconHighlighted'))
                        prevLink.removeClass('iconHighlighted').addClass('iconSelectable'); 
                }.bind(this),
                'click': function() {
                    if (this.curPage != 1) {
                        this.requestData(this.prevPage.toString());
                        prevLink.removeClass('iconHighlighted').addClass('iconUnselectable');
                    }
                    return false;
                }.bind(this)
            }
        });       
        prevLink.addClass('iconSelectable');
        prevLink.inject(this.tableNav);        
        var prevLinkImage = new Element('img', {
            'id': 'prevIcon',
            'src': CONFIG['image_dir'] + '/filtertable-prev.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        prevLinkImage.inject(prevLink); 
        
        // next item link
        var nextLink = new Element('a', {
            'id': 'nextButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (this.curPage != this.maxPages) {
                        if (nextLink.hasClass('iconSelectable'))
                            nextLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                        else if (nextLink.hasClass('iconUnselectable'))
                            nextLink.removeClass('iconUnselectable').addClass('iconHighlighted');
                    }
                }.bind(this),
                'mouseleave': function() {
                    if (nextLink.hasClass('iconHighlighted'))
                        nextLink.removeClass('iconHighlighted').addClass('iconSelectable'); 
                }.bind(this),
                'click': function() {
                    if (this.curPage != this.maxPages) {
                        this.requestData(this.nextPage.toString());
                        nextLink.removeClass('iconHighlighted').addClass('iconUnselectable');
                    }
                    return false;
                }.bind(this)
            }
        });       
        nextLink.addClass('iconSelectable');
        nextLink.inject(this.tableNav);        
        var nextLinkImage = new Element('img', {
            'id': 'nextIcon',
            'src': CONFIG['image_dir'] + '/filtertable-next.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        nextLinkImage.inject(nextLink);
        
        // last item link
        var lastLink = new Element('a', {
            'id': 'lastButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (this.curPage != this.maxPages) {
                        if (lastLink.hasClass('iconSelectable'))
                            lastLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                        else if (lastLink.hasClass('iconUnselectable'))
                            lastLink.removeClass('iconUnselectable').addClass('iconHighlighted');
                    }
                }.bind(this),
                'mouseleave': function() {
                    if (lastLink.hasClass('iconHighlighted'))
                        lastLink.removeClass('iconHighlighted').addClass('iconSelectable'); 
                }.bind(this),
                'click': function() {
                    if (this.curPage != this.maxPages) {
                        this.requestData(this.maxPages.toString());
                        lastLink.removeClass('iconHighlighted').addClass('iconUnselectable');
                    }
                    return false;
                }.bind(this)
            }
        });       
        lastLink.addClass('iconSelectable');
        lastLink.inject(this.tableNav);        
        var lastLinkImage = new Element('img', {
            'id': 'lastIcon',
            'src': CONFIG['image_dir'] + '/filtertable-last.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        lastLinkImage.inject(lastLink);

        // separator
        var separator2 = new Element('label', {
            'id': 'separator2',
        });
        separator2.addClass('iconSeparator');
        separator2.inject(this.tableNav);
        
        // filter label
        var filterLabel = new Element('label', {
            'id': 'searchLabel',
            'html': 'Filter:',
            'styles': {
                'margin-left': '5px',
                'margin-right': '2px'
            }    
        });
        filterLabel.inject(this.tableNav);        
        // filter selection list
        filterSelect = new Element('select', {
            'id': 'filterColumn',
            'styles': {
                'margin-top': '2px',
                'margin-right': '5px',
                'font-size': '9pt'
            }   
        });
        filterSelect.inject(this.tableNav);
        // filter input box
        filterInput = new Element('input', {
            'id': 'filterString',
            'name': 'filterString',
            'class': 'formInputText',
            'type': 'text',
            'maxlength': 80,
            'value': '',
            'styles': {
                'width': '100px',
                'font-size': '9pt'
            },
            'events': {
                'keyup': function(e) {
                    if (e.key == 'enter') {
                        new Event(e).stop();
                        $('filterString').fireEvent('update');
                    }
                }.bind(this),
                'blur': function(e) {
                    // ignore for now
                }.bind(this),
                'update': function() {
                    this.requestData(1);
                }.bind(this)
            }
        });
        filterInput.inject(this.tableNav);        
        // filter Link
        var filterLink = new Element('a', {
            'id': 'filterButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (filterLink.hasClass('iconSelectable')) {
                        filterLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                    }
                },
                'mouseleave': function() {
                    if (filterLink.hasClass('iconHighlighted')) {
                        filterLink.removeClass('iconHighlighted').addClass('iconSelectable');  
                    }
                },
                'click': function() {
                    filterInput.fireEvent('update');
                    return false;
                }.bind(this)
            }
        });       
        filterLink.addClass('iconSelectable');
        filterLink.inject(this.tableNav);        
        var filterLinkImage = new Element('img', {
            'src': CONFIG['image_dir'] + '/filtertable-filter.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        filterLinkImage.inject(filterLink);       
        
        // separator
        var separator3 = new Element('label', {
            'id': 'separator3',
        });
        separator3.addClass('iconSeparator');
        separator3.inject(this.tableNav);
        
        // refresh Link
        var refreshLink = new Element('a', {
            'id': 'refreshButton',
            'href': '',
            'events': {
                'mouseenter': function() {
                    if (refreshLink.hasClass('iconSelectable')) {
                        refreshLink.removeClass('iconSelectable').addClass('iconHighlighted');  
                    }
                },
                'mouseleave': function() {
                    if (refreshLink.hasClass('iconHighlighted')) {
                        refreshLink.removeClass('iconHighlighted').addClass('iconSelectable');  
                    }
                },
                'click': function() {
                    this.requestData(this.curPage);
                    return false;
                }.bind(this)
            }
        });       
        refreshLink.addClass('iconSelectable');
        refreshLink.inject(this.tableNav);        
        var refreshLinkImage = new Element('img', {
            'id': 'refreshIcon',
            'src': CONFIG['image_dir'] + '/filtertable-refresh.png',
            'styles': {
                'vertical-align': 'middle',
                'margin-bottom': '2px'
            },
        });        
        refreshLinkImage.inject(refreshLink); 
        
        waitingSpan = new Element('span', {
            'id': 'waiting',
            'html': 'Processing...',
            'styles': {
                'margin-left': '5px',              
                'visibility': 'hidden'
            }
        });
        waitingSpan.inject(this.tableNav);
        
    }, // end of createNavigation
    
    /*
     * createHeaders: create the table header row
     */
    createHeader: function() {            
        // create the column headers
        this.headers.each(function(header, index) {
            var headerTd = new Element('th', {
                'id': header['id'],
                'styles': {
                    'cursor': 'col-resize'
                },
            });            
            
            // add to filter if set
            if (header['searchable']) {                
                var option = new Element('option', {
                    'id': header['id'],
                    'value': header['id'],
                    'html': header['caption']
                });
                option.inject(this.filterSelect);
            }
            
            // remember which is the key field for edit, delete etc
            if (header['id'] == this.key) {
                this.keyIndex = index;
            }
            this.numColumns = index;
            
            // add the click event for column re-ordering
            if (header['sortable']) {
                var tdAnchor = new Element('a', {
                    'id': header['id'],
                    'href': '',
                    'html': header['caption'],               
                    'events': {
                        'click': function(e) {
                            e.preventDefault();
                            // are we already sorting on this column
                            if (this.sortColumn == header['id']) { 
                                // if so, change sort direction
                                if (this.sortDirection == 'DESC') {
                                    this.sortDirection = ""; 
                                    headerTd.removeClass('sortedDESC').addClass('sortedASC');                                    
                                } else { 
                                    this.sortDirection = "DESC";
                                    headerTd.removeClass('sortedASC').addClass('sortedDESC');
                                } 
                            }
                            else { 
                                this.sortColumn = header['id']; 
                                this.sortDirection = ''; 
                                $$('th.sortedDESC').each(function(th) {
                                    th.removeClass('sortedDESC');
                                });
                                $$('th.sortedASC').each(function(th) {
                                    th.removeClass('sortedASC');
                                });
                                headerTd.addClass('sortedASC');
                            } 
                            // fire an update
                            $('filterString').fireEvent('update');
                        }.bind(this)
                    }
                });
                headerTd.inject(this.tableHeadTr);
                tdAnchor.inject(headerTd);
            }  else {
                headerTd.set('html', header['caption']);                
                headerTd.inject(this.tableHeadTr);
            }
            headerTd.makeResizable({
                grid: 4,
                snap: 0,
                modifiers: {x: 'width', y: false},
                limit: {x: [50, 800]}
            });
        }, this);        
        
    }, // end of createHeaders
    
    /*
     * requestData: request the table data via AJAX
     */
    requestData: function(page) {  
        var req = new Request.JSON({
            url: this.url,
            method: 'get',
            evalScripts: true,
            onRequest: function() {
                this.busy = true;
                $('waiting').setStyle('visibility', 'visible');  
                $('refreshIcon').src = CONFIG['image_dir'] + '/filtertable-loading.gif';
            }.bind(this),
            onSuccess: function(response) {
                if (response == null) {
                    // TODO: write error
                    alert("Invalid JSON result");
                } else {
                    // TODO: check response.code
                  
                    this.maxPages   = response.max;
                    this.curPage    = response.page
                    this.prevPage   = parseInt(this.curPage) - 1; // previous page
                    this.nextPage   = parseInt(this.curPage) + 1; // next page
                    this.numEntries = response.entries; 
                    
                    // disable buttons, based on where we are
                    if (this.maxPages == 1) { 
                        // we have just one page
                        $('firstIcon').src = CONFIG['image_dir'] + '/filtertable-first-grey.png';
                        $('nextIcon').src = CONFIG['image_dir'] + '/filtertable-next-grey.png';
                        $('prevIcon').src = CONFIG['image_dir'] + '/filtertable-prev-grey.png';
                        $('lastIcon').src = CONFIG['image_dir'] + '/filtertable-last-grey.png'; 
                    } else if (this.curPage == 1) { 
                        // we have more than one page, but are on first
                        $('firstIcon').src = CONFIG['image_dir'] + '/filtertable-first-grey.png';
                        $('nextIcon').src = CONFIG['image_dir'] + '/filtertable-next.png';
                        $('prevIcon').src = CONFIG['image_dir'] + '/filtertable-prev-grey.png';
                        $('lastIcon').src = CONFIG['image_dir'] + '/filtertable-last.png'; 
                    } else if (this.curPage == this.maxPages) { 
                        // we have more than one page, but are on last
                        $('firstIcon').src = CONFIG['image_dir'] + '/filtertable-first.png';
                        $('nextIcon').src = CONFIG['image_dir'] + '/filtertable-next-grey.png';
                        $('prevIcon').src = CONFIG['image_dir'] + '/filtertable-prev.png';
                        $('lastIcon').src = CONFIG['image_dir'] + '/filtertable-last-grey.png'; 
                    } else { 
                        // we can go in either direction
                        $('firstIcon').src = CONFIG['image_dir'] + '/filtertable-first.png';
                        $('nextIcon').src = CONFIG['image_dir'] + '/filtertable-next.png';
                        $('prevIcon').src = CONFIG['image_dir'] + '/filtertable-prev.png';
                        $('lastIcon').src = CONFIG['image_dir'] + '/filtertable-last.png'; 
                    } 
                                        
                    // populate the table
                    if (this.numEntries == 0)
                        alert("No matching rows found.");
                    else
                        this.parseResponse(response.data);
                                                   
                }
                this.busy = false;
                $('waiting').setStyle('visibility', 'hidden');
                $('refreshIcon').src = CONFIG['image_dir'] + '/filtertable-refresh.png';
                       
            }.bind(this),
            onFailure: function(response) {
                $('tableContent').set('html', "<p class='error'>Error fetching results</p>");
            }.bind(this)
        }).send('searchstring=' + $('filterString').get('value')
                + "&searchcolumn=" + $('filterColumn').get('value')
                + "&sortcolumn=" + this.sortColumn
                + "&sortdirection=" + this.sortDirection
                + "&page=" + page
                + "&rows=" + this.rowsPerPage
                + "&time=" + ($random(0, 100) - $time()).toString());
    }, // end of requestData
    
    /*
     * parseResponse: parse the response from requestData and create the table entries
     */
    parseResponse: function(rows) {
        // empty the table first...
        this.tableBody.empty();       
        
        rows.each(function(row, index) {
            var index = index + 1;
            
            // create a new row...
            var tr = new Element('tr');
            // check if it's an even row...
            var cssClass = index % 2 == 0 ? 'even' : 'odd';
            tr.addClass(cssClass).addEvents({
                'mouseenter': function () {
                    if (!tr.hasClass('selected'))
                        tr.addClass('highlighted').removeClass(cssClass);
                }.bind(this),
                'mouseleave': function () {
                    if (!tr.hasClass('selected'))
                        tr.removeClass('highlighted').addClass(cssClass);                      
                }.bind(this),
                'click': function() { // select or unselect table row
                    if (this.options.singleSelect && this.rowSelected) {
                        if (tr.hasClass('selected')) {
                            tr.removeClass('selected').addClass(cssClass).addClass('highlighted');
                            $('editIcon').src = CONFIG['image_dir'] + '/filtertable-edit-grey.png';
                            $('editLink').removeClass('iconSelectable').addClass('iconUnselectable');
                            $('deleteIcon').src = CONFIG['image_dir'] + '/filtertable-del-grey.png';
                            $('deleteLink').removeClass('iconSelectable').addClass('iconUnselectable');
                            this.rowSelected = false;
                        }
                    } else {
                        if (!tr.hasClass('selected')) {
                            this.rowSelected = true;
                            tr.removeClass(cssClass).removeClass('highlighted').addClass('selected');                            
                            $('editIcon').src = CONFIG['image_dir'] + '/filtertable-edit.png';
                            $('editLink').removeClass('iconUnselectable').addClass('iconSelectable');
                            $('deleteIcon').src = CONFIG['image_dir'] + '/filtertable-del.png';
                            $('deleteLink').removeClass('iconUnselectable').addClass('iconSelectable');
                        } else {
                            tr.removeClass('selected').addClass(cssClass).addClass('highlighted');
                            if ($$('tr.selected').length == 0) {
                                $('editIcon').src = CONFIG['image_dir'] + '/filtertable-edit-grey.png';
                                $('editLink').removeClass('iconSelectable').addClass('iconUnselectable');
                                $('deleteIcon').src = CONFIG['image_dir'] + '/filtertable-del-grey.png';
                                $('deleteLink').removeClass('iconSelectable').addClass('iconUnselectable');
                                this.rowSelected = false;
                            }
                        }
                    }
                }.bind(this),
                'dblclick': function() {    // edit the table row
                    window.location = tr.getChildren("td")[this.keyIndex].getChildren("a")[0].get('href');
                }.bind(this)
            });
                            
            row.each(function(cell, column) {  
                // add an edit link if this is the key field
                if (column == this.keyIndex) {
                    var td = new Element('td', {
                        'id': row[this.keyIndex]
                    });
                    var tdAnchor = new Element('a', {
                        'href': this.options.editurl + "?" + this.key + '=' + row[this.keyIndex],
                        'html': cell                                      
                    });
                    td.inject(tr);
                    tdAnchor.inject(td);
                } else {
                    var td = new Element('td', {
                        'html': cell
                    });
                    td.inject(tr);
                }
                column = column + 1;                
            }, this);
            tr.inject(this.tableBody);
        }, this);  
        
        // create the table footer
        this.createFooter();
    }, // end of parseData
    
    /*
     * createFooter: create the table footer row
     */
    createFooter: function() {              
        // empty the table footer first...
        this.tableFootTr.empty(); 
        
        // create single table column
        var tableFootTd = new Element('td', {
            'colspan': this.numColumns
        });
        tableFootTd.inject(this.tableFootTr);
        // create number of entries label        
        var numEntriesLabel = new Element('label', {
            'id': 'numEntriesLabel',
            'html': 'Found ' + this.numEntries + ' matching entries',
            'styles': {
                'margin-left': '2px',
                'margin-right': '2px'
            }    
        });
        numEntriesLabel.inject(tableFootTd);
        
        // separator
        var separator1 = new Element('label', {
            'id': 'separator1',
        });
        separator1.addClass('iconSeparator');
        separator1.inject(tableFootTd);        
        
       // rows label
        var rowsLabel = new Element('label', {
            'id': 'rowsLabel',
            'html': 'Showing ',
            'styles': {
                'margin-left': '5px',
                'margin-right': '2px'
            }    
        });
        rowsLabel.inject(tableFootTd);              
        // rows per page input box
        rowsInput = new Element('input', {
            'id': 'rowsString',
            'name': 'rowsString',
            'class': 'formInputText',
            'type': 'text',
            'maxlength': 80,
            'value': this.rowsPerPage,
            'styles': {
                'width': '20px',
                'font-size': '9pt'
            },
            'events': {
                'keyup': function(e) {
                    if (e.key == 'enter') {
                        new Event(e).stop();
                        rowsInput.fireEvent('update');
                    }
                }.bind(this),
                'blur': function(e) {
                    // ignore for now
                }.bind(this),
                'update': function(e) {
                    this.rowsPerPage = rowsInput.get('value');                    
                    this.requestData(1);
                }.bind(this)
            }
        });
        rowsInput.inject(tableFootTd); 
        var rowsLabel2 = new Element('label', {
            'id': 'rowsLabel2',
            'html': ' rows per page',
            'styles': {
                'margin-left': '2px',
                'margin-right': '5px'
            }    
        });
        rowsLabel2.inject(tableFootTd); 
        
        // separator
        var separator2 = new Element('label', {
            'id': 'separator2',
        });
        separator2.addClass('iconSeparator');
        separator2.inject(tableFootTd);
        
        // show all link
        var allRowsLink = new Element('a', {
            'id': 'allRows',
            'html': 'Show All',
            'href': '',
            'styles': {
                'margin-left': '5px',
                'margin-right': '5px'
            },  
            'events': {
                'click': function(e) {
                    new Event(e).stop();
                    this.rowsPerPage = this.numEntries;
                    this.requestData(1);
                }.bind(this)
            }
        });   
        allRowsLink.inject(tableFootTd);      
        
    } // end of createFooter

});