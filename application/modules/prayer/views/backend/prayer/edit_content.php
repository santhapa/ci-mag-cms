<div class="box-body">
    <form class="form-horizontal validate" method="POST" action="">

        <div class="form-group">
            <label class="col-sm-2 control-label" for="prayerRequest">Prayer Request</label>
            <div class="col-sm-8">
                <textarea class="form-control required" id="prayerRequest" name="prayerRequest" rows="10" placeholder="Prayer Message" required><?php echo set_value('prayerRequest')?:$prayer->getPrayerRequest(); ?></textarea>
                <?php echo form_error('prayerRequest'); ?>    
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label" for="verseMessage">Message</label>
            <div class="col-sm-4">
                <textarea class="form-control required" id="verseMessage" rows="5" name="verseMessage" placeholder="Message from verse" required><?php echo set_value('verseMessage')?:$prayer->getVerseMessage(); ?></textarea>
                <?php echo form_error('verseMessage'); ?>    
            </div>
            <label class="col-sm-2 control-label" for="verse">Verse</label>
            <div class="col-sm-2">
                <input class="form-control required" type="text" id="verse" name="verse" value="<?php echo set_value('verse')?:$prayer->getVerse(); ?>" placeholder="Verse" required>
                <?php echo form_error('verse'); ?>    
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="date">Date</label>
            <div class="col-sm-8">
            	<input class="form-control required" type="date" id="date" name="date" value="<?php echo set_value('date')?:$prayer->getDate()->format('Y-m-d'); ?>" placeholder="Date of Prayer Request" required>
                <?php echo form_error('date'); ?>    
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="imageURL">Image URL</label>
            <div class="col-sm-8">
                <input class="form-control required" type="text" id="imageURL" name="imageURL" value="<?php echo set_value('imageURL')?:$prayer->getImageURL(); ?>" placeholder="Copy and paste image link" required>
                <?php echo form_error('imageURL'); ?>    
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-info" value="Update">Update</button>
            </div>
        </div>

    </form>
</div>