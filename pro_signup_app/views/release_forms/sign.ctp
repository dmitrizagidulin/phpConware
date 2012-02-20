<h2>Readercon 22 Consent and Release</h2>

<p>1. In the event the undersigned Participant participates in Readercon
22 programming, the undersigned, in consideration for their membership
and participation in the conference, hereby grants Readercon the
unlimited, worldwide, irrevocable permission to use, distribute,
publish, license, exhibit, record, digitize, broadcast, reproduce and
archive, in any format or medium, whether now known or hereafter
developed: (a) the Participant's presentation and comments at the
conference; (b) any written materials or multimedia files used in
connection with the Participant's presentation; and (c) any recorded
interviews of the Participant (collectively, the "Participation"). The
permission granted includes the transcription and reproduction of the
Participation for inclusion in products sold or distributed by
Readercon, and the live or recorded broadcast of the Participation
during or after the conference.
</p>

<p>2. In connection with the permission granted in Section 1, the
Participant hereby grants Readercon the unlimited, worldwide,
irrevocable right to use the Participant's name, picture, likeness,
voice and biographical information as part of the advertisement,
distribution and sale of products incorporating the Participation, and
releases Readercon from any claim based on right of privacy or
publicity.</p>

<p>3. The undersigned retains all proprietary rights to their literary or
artistic works that are presented at Readercon 22.</p>

<?php echo $this->Form->create('ReleaseForm'); ?>

<p><?php echo $this->Form->checkbox('ReleaseForm.edu_checkbox');?> If this box is checked, Readercon will only distribute recordings
of the undersigned's Participation for educational purposes.</p>

<h2>General Terms</h2>

<ul>
<li>The undersigned represents that they have the power and authority to
make and execute this assignment.</li>


<li>The undersigned agrees to indemnify and hold harmless Readercon from
any damage or expense that may arise in the event of a breach of any
of the warranties set forth above.</li>
</ul>
<br />
<p>
<label>Participant's full legal name:</label>
<?php echo $this->Form->input('ReleaseForm.name', array('label'=>false));?>
</p>
<p>
<label>Date:</label>
<?php echo $this->Form->input('ReleaseForm.date', array('label'=>false));?>
</p>
<?php echo $this->Form->end(__(' Next ', true));?>
