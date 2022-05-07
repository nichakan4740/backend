package sit.int221.oasip.Entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.sql.Timestamp;
import java.time.Instant;
import java.time.LocalTime;
import java.util.LinkedHashSet;
import java.util.Set;
import javax.persistence.Id;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;


@Getter
@Setter
@Entity
@Table(name = "event")
public class Event {
    @Id
    @Column(name = "eventID", nullable = false)
//    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(name = "bookingName", nullable = false, length = 100)
    private String bookingName;

    @Column(name = "eventEmail", length = 50)
    private String eventEmail;

//    @Column(name = "eventCategory", nullable = false, length = 100)
//    private String eventCategory;

    @Column(name = "eventNotes", length = 500)
    private String eventNotes;

    @Column(name = "eventStartTime", nullable = false)
    private Instant eventStartTime;

    @Column(name = "eventDuration", nullable = false)
    private Integer eventDuration;


//    @JsonIgnore
    @ManyToOne
    @JoinColumn(name = "eventCategoryID")
    private Eventcategory eventCategoryID;

//    @OneToOne(mappedBy = "event")
//    private Eventcategory eventcategory;

}