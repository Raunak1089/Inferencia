import tkinter as tk
from tkinter import filedialog
import script as ams
import qrcode
import json
import webbrowser


def browse_file():
    file_path = filedialog.askopenfilename()
    global data
    try:
        with open(file_path, 'r') as json_file:
            data = json.load(json_file)

        file_name = file_path.split("/")[-1]
        file_input.config(text=file_name)
        print("Selected file:", file_path)

    except Exception as e:
        print("Error:", e)


def gen_qr():
    try:
        for item in data:
            qr_data = item['regId']
            qr = qrcode.QRCode(version=1, box_size=10, border=1)
            qr.add_data(qr_data)
            qr.make(fit=True)
            img = qr.make_image(fill_color='#010c48', back_color='#bddbff')
            img.save(f'qrimages/{item["regId"]}.png')
        qr_completed_label.config(text="QR generation completed!")
    except Exception as e:
        qr_completed_label.config(text=str(e))


rkmrc = [
    "OXJSYacp",
    "QFK3RamB",
    "GIVZQ2Zk",
    "OpysGerv",
    "WtAHKx8C",
    "wgsGPuyt",
    "RBZc7WsA"
]

global mails_sent_number
mails_sent_number = 0


def send_mails():
    global mails_sent_number
    try:
        for item in data:
            if item['regId'] not in rkmrc:
                if item['stochastoliga'] == "0":
                    with open('conf_email.html', 'r') as file:
                        emailBody = file.read()
                    # else:
                    #     with open('email.html', 'r') as file:
                    #         emailBody = file.read()

                    service = ams.get_service()
                    user_id = 'me'
                    this_body = emailBody.replace('ParticipantName', item['name'].split(' ')[0].capitalize())
                    this_body = this_body.replace('imgSrc', f'cid:qrimages/{item["regId"]}.png')
                    msg = ams.create_message(entry.get(),
                                             item['email'],
                                             'Confirmation for Inferencia',
                                             this_body,
                                             f"{item['regId']}.png")
                    sm = ams.send_message(service, user_id, msg)
                    mails_sent_number += 1
                    print(f'{mails_sent_number}. Message Id: {sm["id"]} sent to {item["email"]}')

        qr_completed_label.config(text="All mails sent!")
    except Exception as e:
        qr_completed_label.config(text=str(e))


def show_email():
    webbrowser.open('email.html')


root = tk.Tk()
root.title("QR Code and Mail Sender")

# Set the background color to wheat
root.configure(background='wheat')

# Set the size of the window
root.geometry("700x400")

# Create a label to display the message
direction_label = tk.Label(root, text="Keep the RegIDs in 1st column and emails in 2nd column of the JSON file. "
                                      "\nProvide a header row at the top too.")
direction_label.pack()

# Set the position of the label
direction_label.place(relx=0.5, rely=0.1, anchor=tk.CENTER)

sending_mail = tk.Label(root, text="Emails to be sent from: ")
sending_mail.pack()
sending_mail.place(relx=0.2, rely=0.2, anchor="w")
entry = tk.Entry(root, width=30)
entry.insert(0, "inferencia.rkmrc@gmail.com")
entry.pack()
entry.place(relx=0.6, rely=0.2, anchor=tk.CENTER)

# Create a frame to hold the buttons and file input widget
button_frame = tk.Frame(root)
button_frame.pack(pady=20)

# Create the "GEN QR" button
gen_qr_button = tk.Button(button_frame, text="GEN QR", command=gen_qr, bg='grey', borderwidth=0, relief='solid',
                          padx=20, pady=10, bd=0, highlightthickness=0, cursor='hand2', font=('Arial', 12), fg='white')
gen_qr_button.pack(side=tk.LEFT, padx=10)

# Create the "SEND MAILS" button
send_mails_button = tk.Button(button_frame, text="SEND MAILS", command=send_mails, bg='grey', borderwidth=0,
                              relief='solid', padx=20, pady=10, bd=0, highlightthickness=0, cursor='hand2',
                              font=('Arial', 12), fg='white')
send_mails_button.pack(side=tk.LEFT, padx=10)

# Create the "SHOW EMAIL" button
show_email_button = tk.Button(button_frame, text="SHOW EMAIL", command=show_email, bg='grey', borderwidth=0,
                              relief='solid', padx=20, pady=10, bd=0, highlightthickness=0, cursor='hand2',
                              font=('Arial', 12), fg='white')
show_email_button.pack(side=tk.LEFT, padx=10)

# Create the file input widget
file_input = tk.Label(root, text="Open JSON file", bg='white', bd=2, relief=tk.GROOVE, height=5, width=30)
file_input.pack(pady=10)

# Allow the user to drop a file onto the file input widget
file_input.bind("<Button-1>", lambda e: browse_file())

# Set the position of the frame
button_frame.place(relx=0.5, rely=0.4, anchor=tk.CENTER)

# Set the position of the file input widget
file_input.place(relx=0.5, rely=0.7, anchor=tk.CENTER)

# Create a label to display the message
qr_completed_label = tk.Label(root, text="")
qr_completed_label.pack()

# Set the position of the label
qr_completed_label.place(relx=0.5, rely=0.9, anchor=tk.CENTER)

# Start the main event loop
root.mainloop()
